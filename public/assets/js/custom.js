function setAjaxData(object = null) {
  var data = {};
  data[BaseConfig.csrfTokenName] = $('meta[name="X-CSRF-TOKEN"]').attr('content');
  if (object != null) {
    Object.assign(data, object);
  }
  return data;
}

function setSerializedData(serializedData) {
  serializedData.push({ name: BaseConfig.csrfTokenName, value: $('meta[name="X-CSRF-TOKEN"]').attr('content') });
  return serializedData;
}

//delete item
function deleteItem(url, id, message) {
  swal({
    text: message,
    icon: "warning",
    buttons: [BaseConfig.textCancel, BaseConfig.textOk],
    dangerMode: true,
  }).then(function (willDelete) {
    if (willDelete) {
      var data = {
        'id': id,
      };
      $.ajax({
        type: 'POST',
        url: BaseConfig.baseURL + url,
        data: setAjaxData(data),
        success: function (response) {
          location.reload();
        },
        error: function (xhr, status, thrown) {
          console.log(xhr);
          console.log(status);
          console.log(thrown);
        },
      });
    }
  });
};

function fetchDepartemenJabatanData(type, target) {
  const url = type === 'departemen' ? BaseConfig.baseURL + 'admin/departemen/list-data' : BaseConfig.baseURL + 'admin/jabatan/list-data';
  const textProcessing = type === 'departemen' ? 'Daftar departemen muncul disini' : 'Daftar Jabatan muncul disini';

  $(target).html('<div id="loadingSpinner" class="spinner"></div><p class="text-center mt-3">' + textProcessing + '</p>');

  $.ajax({
    url: url,
    type: 'post',
    data: setAjaxData({}),
    success: function (response) {
      try {
        const obj = JSON.parse(response);
        if (obj.result === 1) {
          $(target).html(obj.htmlContent);
        } else {
          const errorMsg = obj.error || 'Data tidak ditemukan';
          $(target).html('<div class="alert alert-danger text-center mt-3">' + errorMsg + '</div>');
        }
      } catch (e) {
        $(target).html('<div class="alert alert-danger text-center mt-3">Error parsing response: ' + e.message + '</div>');
      }
    },
    error: function (xhr, status, thrown) {
      let errorMsg = 'Terjadi kesalahan: ' + thrown;
      if (xhr.responseText) {
        try {
          const response = JSON.parse(xhr.responseText);
          if (response.error) {
            errorMsg = response.error;
          }
        } catch (e) {
          // If response is not JSON, use the response text
          errorMsg = xhr.responseText || errorMsg;
        }
      }
      $(target).html('<div class="alert alert-danger text-center mt-3">' + errorMsg + '</div>');
    },
    complete: function () {
      $('#loadingSpinner').hide();
    }
  });
}

//delete selected posts
function deleteSelectedKaryawan(message) {
  swal({
      text: message,
      icon: "warning",
      buttons: [BaseConfig.textCancel, BaseConfig.textOk],
      dangerMode: true,
  }).then(function (willDelete) {
      if (willDelete) {
          var karyawanIds = [];
          $("input[name='checkbox-table']:checked").each(function () {
              karyawanIds.push(this.value);
          });
          var data = {
              'karyawan_ids': karyawanIds,
          };
          $.ajax({
              type: 'POST',
              url: BaseConfig.baseURL + '/admin/karyawan/deleteSelectedKaryawan',
              data: setAjaxData(data),
              success: function (response) {
                  location.reload();
              }
          });
      }
  });
};

$(document).on('click', '#checkAll', function () {
  $('input:checkbox').not(this).prop('checked', this.checked);
});

$(document).on('click', '.checkbox-table', function () {
  if ($(".checkbox-table").is(':checked')) {
    $(".btn-table-delete").show();
  } else {
    $(".btn-table-delete").hide();
  }
});

