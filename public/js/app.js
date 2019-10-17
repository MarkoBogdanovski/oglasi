(function() {
  "use strict";

  $('.toast').toast('show');

  $("#categorySearch").select2({
    placeholder: "Select category",
    theme: "bootstrap4",
    ajax: {
      url: "/categories",
      dataType: "json",
      processResults: function(data) {
        return {
          results: $.map(data, function(category) {
            return {
              text: category.display_name,
              id: category.name
            };
          })
        };
      },
      cache: true
    }
  });
  $("#categorySearch").on("change", function() {
    var q = $("#search").val();
    var category = $("#categorySearch").val();
    $.ajax({
      url: "/search",
      type: "post",
      data: {
        _token: "{{ csrf_token() }}",
        category: category,
        q: q
      },
      dataType: "html",
      success: function(response) {
        $("#ads").empty().html(response);
      }
    });
  });
})();
