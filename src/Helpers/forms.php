<?php

use Adminro\Classes\Form;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

function customizeValidated($validated, $forms)
{
    foreach ($forms as $key => $form) {
        if (isset($validated[$key]) && $validated[$key] !== null && $validated[$key] !== "") {
            if (env('DB_CONNECTION') == 'mongodb') {
                if ($form->type() == "map") {
                    if ($validated[$key]["latitude"] != 0 || $validated[$key]["longitude"] != 0) {
                        $validated[$key] = ["type" => "Point", "coordinates" => [(float)$validated[$key]["longitude"], (float)$validated[$key]["latitude"]]];
                    } else {
                        $validated[$key] = null;
                    }
                }
            }

            if ($key == "password") {
                $validated[$key] = Hash::make($validated[$key]);
            }

            if ($form->dataType() == "int") {
                $validated[$key] = (int)$validated[$key];
            }

            if ($form->dataType() == "double") {
                $validated[$key] = (float)$validated[$key];
            }
        }

        if ($form->type() == "tagify") {
            $tagify_values = json_decode($validated[$key]) ?? [];
            $validated[$key] = collect($tagify_values)->pluck('value')->toArray();
        }

        if ($form->type() == "switch") {
            if ($validated[$key]) {
                $validated[$key] = 1;
            } else {
                $validated[$key] = 0;
            }
        }
    }

    return $validated;
}

function postSaveModel($model, $validated, $forms, $isStore, $storeFolderName = null)
{
    $image_quality = env('FORM_IMAGE_QUALITY', 75);

    foreach ($forms as $key => $form) {
        if (isset($validated[$key])) {
            if (env('DB_CONNECTION') == 'mysql') {
                if ($form->type() == "map") {
                    if ($validated[$key]["latitude"] != 0 || $validated[$key]["longitude"] != 0) {
                        $location = new Point($validated[$key]["latitude"], $validated[$key]["longitude"]);
                        $model[$key] = $location;
                    } else {
                        $model[$key] = null;
                    }
                }
            }
        }

        if ($form->type() == "file") {
            if (isset($validated[$key]) && $validated[$key] !== null && $validated[$key] !== "") {
                $fileStoreName = null;
                $file = $validated[$key];
                if ($file) {
                    if (!$isStore) removeFileFromStorage($model, $key, $form);

                    $fileStoreName = 'file-' . Str::random(16) . '.' . $file->extension();
                    Storage::putFileAs("public/$storeFolderName/", $file, $fileStoreName);
                    $model[$key] = $fileStoreName;
                    $model[$key . "_path"] = $storeFolderName;
                }
            } else if (isset($validated[$key]) && !isset($model[$key])) {
                $model[$key] = null;
                $model[$key . "_path"] = null;
            }
        } else if ($form->type() == "image") {
            if (isset($validated[$key]) && $validated[$key] !== null && $validated[$key] !== "") {
                $fileStoreName = null;
                $file = $validated[$key];
                if ($file) {
                    if (!$isStore) removeFileFromStorage($model, $key, $form);

                    $source = $file->getRealPath();
                    $fileStoreName = 'file-' . Str::random(16) . '.' . $file->extension();
                    $targetFolder = public_path("storage/$storeFolderName");
                    $targetFile = "$targetFolder/$fileStoreName";
                    checkFolder($targetFolder);
                    $file = Image::make($source)->save($targetFile, $image_quality);
                    $fileHeight = $file->getHeight();
                    $fileWidth = $file->getWidth();
                    $model[$key] = $fileStoreName;
                    $model[$key . "_path"] = $storeFolderName;
                    $model[$key . '_width'] = $fileWidth;
                    $model[$key . '_height'] = $fileHeight;

                    foreach ($form->sizes() as $size) {
                        $height = $size[0];
                        $width = $size[1];

                        $targetFolder = public_path("storage/$storeFolderName/{$height}x{$width}");
                        $targetFile = "$targetFolder/$fileStoreName";
                        checkFolder($targetFolder);
                        $file = Image::make($source)->resize($height, $width, function ($constraint) {
                            $constraint->aspectRatio();
                        });

                        $canvas = Image::canvas($height, $width);
                        $canvas->insert($file, 'center');
                        $canvas->save($targetFile, $image_quality);
                    }
                }
            } else if (isset($validated[$key]) && !isset($model[$key])) {
                $model[$key] = null;
                $model[$key . "_path"] = null;
                $model[$key . '_width'] = null;
                $model[$key . '_height'] = null;
            }
        } else if ($form->type() == "video") {
            if (isset($validated[$key]) && $validated[$key] !== null && $validated[$key] !== "") {
                $fileStoreName = null;
                $file = $validated[$key];
                if ($file) {
                    if (!$isStore) removeFileFromStorage($model, $key, $form);

                    $fileStoreName = 'file-' . Str::random(16) . '.' . $file->extension();
                    Storage::putFileAs("public/$storeFolderName/", $file, $fileStoreName);
                    $model[$key] = $fileStoreName;
                    $model[$key . "_path"] = $storeFolderName;
                }
            } else if (isset($validated[$key]) && !isset($model[$key])) {
                $model[$key] = null;
                $model[$key . "_path"] = null;
            }
        }
    }
}

function postDeleteModel($model, $forms)
{
    foreach ($forms as $key => $form) {
        if ($form->type() == "file") {
            removeFileFromStorage($model, $key, $form);
        }

        if ($form->type() == "image") {
            removeFileFromStorage($model, $key, $form);
        }

        if ($form->type() == "video") {
            removeFileFromStorage($model, $key, $form);
        }
    }
}

function removeFileFromStorage($model, $key, $form)
{
    $file = $model->getOriginal($key);
    $file_path = $model->getOriginal($key . '_path');

    if ($form instanceof Form) {
        $form = $form->attributes();
    }

    Storage::disk("public")->delete("$file_path/$file");
    foreach ($form['sizes'] as $size) {
        $height = $size[0];
        $width = $size[1];

        $targetFile = "$file_path/{$height}x{$width}/$file";
        Storage::disk("public")->delete($targetFile);
    }
}

function formatModel($model, $forms, $attributes = [])
{
    if (!$model) {
        return null;
    }

    $model_formatted = [];
    foreach ($attributes as $attribute) {
        $model_formatted[$attribute] = $model[$attribute] ?? null;
    }

    foreach ($forms as $key => $form) {
        if (!isset($model[$key]) || !isset($model_formatted[$key])) {
            continue;
        }

        if ($form->type() == "image") {
            $fileName = $model[$key];
            $filePath = $model[$key . '_path'] ?? null;

            $files = collect();
            $files->put('default', getStorageUrl($filePath, $fileName));
            foreach ($form->sizes() as $size) {
                $files->put("{$size[0]}x{$size[1]}", getStorageUrl($filePath, $fileName, "{$size[0]}x{$size[1]}"));
            }

            $model_formatted[$key] = $files;
        }

        if ($form->type() == "date") {
            $model_formatted[$key] = Carbon::parse($model[$key])->tz(env('APP_TIMEZONE'))->format('Y-m-d');

            if (isset($model_formatted[$key . '_time_ago'])) {
                $model_formatted[$key . '_time_ago'] = Carbon::parse($model[$key])->tz(env('APP_TIMEZONE'))->diffForHumans();
            }

            if (isset($model_formatted[$key . '_time_ago_short'])) {
                $model_formatted[$key . '_time_ago_short'] = Carbon::parse($model[$key])->tz(env('APP_TIMEZONE'))->diffForHumans(['parts' => 1, 'short' => true, 'syntax' => CarbonInterface::DIFF_ABSOLUTE]);
            }
        }

        if ($form->type() == "time") {
            $model_formatted[$key] = Carbon::parse($model[$key])->tz(env('APP_TIMEZONE'))->format('h:i a');
        }
    }

    return $model_formatted;
}
