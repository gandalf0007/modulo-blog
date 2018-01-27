@extends('layouts.admin-pro')
@section('content')
@include('alerts.errors')
@include('alerts.request')
@include('alerts.success')
@include('flash::message')



           <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h3 class="text-themecolor"><img src="{{ url('admin/adminpro/images/icon/wordpress.svg') }}" alt="" width="50" height="50" class="responsive"></i>
                  <span class="caption-subject font-red sbold uppercase">Setting Blog</span></h3>
                    </div>
                    <div class="col-md-7 align-self-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{!! URL::to('/panel') !!}">Home</a></li>
                            <li class="breadcrumb-item active"><a href="{!! URL::to('/blog-panel') !!}">Blog</a></li>
                            <li class="breadcrumb-item active"><a href="#">Settings</a></li>
                        </ol>
                    </div>
                    <div class="">
                        <button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>


                    </div>
                </div>



                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

  @if (empty($settings))
    {!!Form::open(['url'=>['blog-settings-disqus-store'],'method'=>'POST' , 'files'=>True])!!}
   @include('admin.configuracion.blog.forms.disqus')
   <button type="submit" class="btn btn-success pull-right">Guardar</button>
   {!!Form::close()!!}

   @else
  {{ Form::model($settings, array('url' => array('blog-settings-disqus-update', $settings->id), 'method' => 'PUT', 'files'=>True)) }}
   @include('admin.configuracion.blog.forms.disqus')
  <button type="submit" class="btn btn-success pull-right">Guardar</button>
   {!!Form::close()!!}
   @endif


   <br><br><br>

   
   @if (empty($settings))
     {!!Form::open(['url'=>['blog-settings-imagen-store'],'method'=>'POST' , 'files'=>True])!!}
   @include('admin.configuracion.blog.forms.imagenDefaul')
   <button type="submit" class="btn btn-success pull-right">Guardar</button>
   {!!Form::close()!!}
  @else
    {!!Form::open(['url'=>['blog-settings-imagen-update'],'method'=>'PUT' , 'files'=>True])!!}
   @include('admin.configuracion.blog.forms.imagenDefaul')
   <button type="submit" class="btn btn-success pull-right">Guardars</button>
   {!!Form::close()!!}
  @endif
  



                          </div>
                        </div>
                    </div>
                </div>






<!-- filemanager -->
@section('mis-scripts')
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>
  var editor_config = {
    path_absolute : "/",
    selector: "textarea.my-editor",
    height: 500,
    plugins: [
      "advlist autolink lists link image charmap print preview hr anchor pagebreak",
      "searchreplace wordcount visualblocks visualchars code fullscreen",
      "insertdatetime media nonbreaking save table contextmenu directionality",
      "emoticons template paste textcolor colorpicker textpattern"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
    relative_urls: false,
    file_browser_callback : function(field_name, url, type, win) {
      var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
      var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

      var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
      if (type == 'image') {
        cmsURL = cmsURL + "&type=Images";
      } else {
        cmsURL = cmsURL + "&type=Files";
      }

      tinyMCE.activeEditor.windowManager.open({
        file : cmsURL,
        title : 'Filemanager',
        width : x * 0.8,
        height : y * 0.8,
        resizable : "yes",
        close_previous : "no"
      });
    }
  };

  tinymce.init(editor_config);
</script>



<!--switch-->
 <script>
    jQuery(document).ready(function() {
        // Switchery
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        $('.js-switch').each(function() {
            new Switchery($(this)[0], $(this).data());
        });
    });
    </script>



<!--upload file Imagen-->
<script>
    $(document).ready(function() {
        // Basic
        $('.dropify').dropify();

        // Translated
        $('.dropify-fr').dropify({
            messages: {
                default: 'Glissez-déposez un fichier ici ou cliquez',
                replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                remove: 'Supprimer',
                error: 'Désolé, le fichier trop volumineux'
            }
        });

        // Used events
        var drEvent = $('#input-file-events').dropify();

        drEvent.on('dropify.beforeClear', function(event, element) {
            return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
        });

        drEvent.on('dropify.afterClear', function(event, element) {
            alert('File deleted');
        });

        drEvent.on('dropify.errors', function(event, element) {
            console.log('Has Errors');
        });

        var drDestroy = $('#input-file-to-destroy').dropify();
        drDestroy = drDestroy.data('dropify')
        $('#toggleDropify').on('click', function(e) {
            e.preventDefault();
            if (drDestroy.isDropified()) {
                drDestroy.destroy();
            } else {
                drDestroy.init();
            }
        })
    });
    </script>
@stop



@endsection