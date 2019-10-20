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
})();
