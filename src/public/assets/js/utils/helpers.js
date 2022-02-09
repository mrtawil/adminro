const urlParam = (name) => {
  var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
  if (!results) {
    return null;
  }
  return results[1] || 0;
}

const capitalizeFirstLetter = (string) => {
  return string.charAt(0).toUpperCase() + string.slice(1);
}

const getArrayValues = (array, key) => {
  return array.map((item) => item[key]);
}

const arrayIncludes = (array, key, value) => {
  return array.filter((item) => item[key] == value).length > 0;
}

const sendRequest = (url, data, method) => {
  let loader = $("#subheader_loader");
  let _token = $("meta[name='csrf-token']").attr("content");
  console.log("url:", url);
  console.log("data:", data);
  return $.ajax({
    url: url,
    type: method,
    dataType: "json",
    data: {
      ...data,
      _token
    },
    beforeSend: function () {
      $(loader).show();
    },
    success: function (response) {
      console.log("response:", response);
      return response;
    },
    error: function (error) {
      alert("Error occured, please try again later");
    },
    complete: function () {
      $(loader).hide();
    }
  });
}
