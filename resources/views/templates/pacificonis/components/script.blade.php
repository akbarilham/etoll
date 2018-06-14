@section('script')

<!-- Theme JS starts-->

{!! HTML::script('templates/pacificonis/bower_components/jquery/dist/jquery.min.js') !!}
{!! HTML::script('templates/pacificonis/bower_components/bootstrap/dist/js/bootstrap.min.js') !!}
{!! HTML::script('templates/pacificonis/bower_components/metisMenu/dist/metisMenu.min.js') !!}
{!! HTML::script('templates/pacificonis/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.js') !!}
{!! HTML::script('templates/pacificonis/bower_components/Waves/dist/waves.min.js') !!}
{!! HTML::script('templates/pacificonis/bower_components/toastr/toastr.js') !!}

{!! HTML::script('templates/pacificonis/js/common.js') !!}
{!! HTML::script('templates/pacificonis/js/demo-switch.js') !!}
{!! HTML::script('templates/pacificonis/js/jquery-mousewheel.js') !!}

<script>
    if($(window).width() >= 1440){
      $(".side-panel").addClass("open");
      $(".sidepanel-toggle").parent().addClass("open");
      $("body").addClass("small-content");
    }
    else{
      $(".side-panel").removeClass("open");
      $(".sidepanel-toggle").parent().removeClass("open");
      $("body").removeClass("three-column-layout small-content");
    }
    
    $(window).resize(function(){
      if($(window).width() >= 1440){
        $(".side-panel").addClass("open");
        $(".sidepanel-toggle").parent().addClass("open");
        $("body").addClass("three-column-layout small-content");
      }
      else{
        $(".side-panel").removeClass("open");
        $(".sidepanel-toggle").parent().removeClass("open");
        $("body").removeClass("three-column-layout small-content");
      }
    });
</script>

<!-- Theme JS ends-->

<!-- Sweetalert -->
{!! HTML::script('js/sweetalert.min.js') !!}
<!-- LoadingOverlay -->
{!! HTML::script('js/loading/loadingoverlay.js') !!}
<!-- Moment -->
{!! HTML::script('js/moment.js') !!}
<!-- Bootstrap Datetimepicker -->
{!! HTML::script('js/bootstrap-datepicker.js') !!}
<!-- Date time picker-->
{!! HTML::script('js/bootstrap-datetimepicker.min.js') !!}
<!-- Parsley Validation js -->
{!! HTML::script('js/parsley.js') !!}
<!-- Scaffolding -->
{!! HTML::script('js/scaffolding.js') !!}

@endsection