$(document).ready(function(){
    $('#cfs_btn').click(function (){
        var mes = $('#cfs_content');
        var t = $('#cfs_title');
        
        if ($.trim(mes.val()) === "") {
            $('#err').html('<span>This field is required!</span>')
            return;
        }
    $.ajax({
        url: 'Engine/Ajax.php',
        type: 'post',
        data: {
            action: 'postCFS',
            msg: mes.val(),
            t: t.val()
        },
        beforeSend: function(){
            $('#cfs_btn').html('<i class="fa fa-spinner fa-spin"></i> &nbsp; Confessing...')

        },
        success: function(){
            location.reload();
        }
    });
    });

});

$(document).on('click', '.upvote', function() {
    var id = $(this).data('id');
    $.ajax({
      type: "POST",
      url: "/Engine/Ajax.php",
      data: {
        action: "upVote",
        id: id,
        user: user
      },
      success: function (data) {
        if (data === "no") {
          $("#vote"+id).html("<p>You already voted!</p>")
          setTimeout(function() {
            $('#vote'+id).fadeOut('fast');
          }, 3000); // <-- time in milliseconds
        } else {
          location.reload();
          window.location.hash = "#confession_"+id;
        }
  
      }
    });
  });

  $(document).on('click', '.downvote', function() {
    var id = $(this).data('id');
    $.ajax({
      type: "POST",
      url: "/Engine/Ajax.php",
      data: {
        action: "downVote",
        id: id,
        user: user
      },
      success: function (data) {
        if (data === "no") {
          $("#vote"+id).html("<p>You already voted!</p>")
          setTimeout(function() {
            $('#vote'+id).fadeOut('fast');
          }, 3000); // <-- time in milliseconds
        } else {
          location.reload();
          window.location.hash = "#confession_"+id;
        }
  
      }
    });
  });

$(document).on('click', '.upvoted',
   function () {

      var id = $(this).data('id');

      $.ajax({
        type: 'POST',
        url: '/Engine/Ajax.php',
        data: {
          action: 'delUpvote',
          id: id,
          user: user
        },
      success: function (data) {
        location.reload();
        window.location.hash = "#confession" +id;
      }
    });
});

$(document).on('click', '.downvoted',
   function () {

      var id = $(this).data('id');

      $.ajax({
        type: 'POST',
        url: '/Engine/Ajax.php',
        data: {
          action: 'delDownvote',
          id: id,
          user: user
        },
      success: function (data) {
        location.reload();
        window.location.hash = "#confession" +id;
      }
    });
});