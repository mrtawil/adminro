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