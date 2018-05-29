@extends('layouts.admin-pro')
@section('content')
@include('alerts.errors')
@include('alerts.request')
@include('alerts.success')
@include('flash::message')



           <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h3 class="text-themecolor"><i class="mdi mdi-wordpress"></i>
                  <span class="caption-subject font-red sbold uppercase">Seccion del Blog</span></h3>
                    </div>
                    <div class="col-md-7 align-self-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{!! URL::to('/panel') !!}">Home</a></li>
                            <li class="breadcrumb-item active"><a href="#">Blog</a></li>
                        </ol>
                    </div>
                </div>





                <div class="row">
                    <div class="col-12">
                        <div class="card">

  <ul class="nav nav-tabs profile-tab" role="tablist">
      <li class="nav-item"> <a class="nav-link active" href="{!! URL::to('/blog-panel') !!}" role="tab" aria-expanded="false">Blog</a> </li>
      <li class="nav-item "> <a class="nav-link" href="{!! URL::to('/blog-categorias') !!}" role="tab" aria-expanded="false">Categorias</a> </li>
      <li class="nav-item "> <a class="nav-link" href="{!! URL::to('/blog-tags') !!}" role="tab" aria-expanded="false">Tags</a> </li>
   </ul>


                            <div class="card-body">



        <h4 class="card-title">
    
    @can('crear-post')
      <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#nuevo-post"><i class="fa fa-plus fa-lg"> </i></button>
    @endcan
      
           </h4>

           


    

                    <div class="table-responsive m-t-40">
                                    <table id="mydatatable" class="table table-hover full-inverse-table hover-table" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Imagen</th>
                                                <th>titulo</th>
                                                <th>Categoria</th>
                                                <th>Author</th>
                                                <th>Status</th>
                                                <th>Creado en</th>
                                                <th>Operaciones</th>
                                                
                                            </tr>
                                        </thead>
                                       
                                          <tbody>
                                         </tbody>
                                        
                                    </table>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>






@include('admin.blog.modal.create')
@include('admin.blog.modal.edit')
@include('admin.blog.modal.delete')
@include('admin.blog.modal.status')





@section('mis-scripts')

 {!!Html::script('admin/adminpro/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js')!!} 

<script>
   jQuery('.mydatepicker, #datepicker').datepicker();
   jQuery('.mydatepicker, #datepicker2').datepicker();
   jQuery('.mydatepicker, #datepicker3').datepicker();
   jQuery('.mydatepicker, #datepicker4').datepicker();
</script>



<script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>


<script>
  function activartabla() {
    $('#mydatatable').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 50,
        pagingType: "full_numbers",
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        
         ajax: 'blog-panel-datatable',
        columns: [

            //ID
            { data: 'id', name: 'id' },

            //Imagen
            { data: null,  render: function ( data, type, row ) {

                if(data.portada == "storage/noticias/noticia.jpg"){
                  return "<img src='storage/noticias/noticia.jpg' alt=' height='100' width='100' >"
                }else{
                  return "<img src='"+data.portada+"' alt=' height='100' width='100' >"
                }


                  }
            },

            //TITULO
            { data: 'titulo', name: 'titulo' },


            //categoria
            { data: 'categoria.nombre', name: 'categoria.nombre' },

            //creadpo por
           { data: 'user.nombre', name: 'user.nombre' },

            //STATUS
            { data: null,  render: function ( data, type, row ) {
            if(data.status == "visible"){
                return "<a href='#status-"+data.id+"' data-toggle='modal' ><span class='label label-success'>"+data.status+"</span></a>" 
                }

              if(data.status == "no visible"){
                return "<a href='#status-"+data.id+"' data-toggle='modal' ><span class='label label-danger'>"+data.status+"" 
                }

                 }
              },

          //creadpo en
           { data: 'created_at', name: 'created_at' },


           //OPERACIONES
            { data: null,  render: function ( data, type, row ) {
            
                return "@can('editar-post')<a  class='btn btn-primary  fa fa-edit' href='blog-edit/"+data.id+"'></a>@endcan      <a class='btn btn-success  fa fa-globe' href='blog/"+data.slug+"'></a>     @can('eliminar-post')<button type='button' class='btn btn-danger  fa fa-trash-o' data-toggle='modal' data-target='#confirmDelete-"+data.id+"'></button>@endcan " 

                }
              },


          
        ],
    });
}
activartabla();
</script>





<!-- ckeditor + filemanager -->
<script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
<script>
  CKEDITOR.config.height = 400;
  CKEDITOR.config.width = 1200;

  CKEDITOR.replace('descripcioncorta',{
    filebrowserImageBrowseUrl: 'laravel-filemanager?type=Images',
    filebrowserImageUploadUrl: 'laravel-filemanager/upload?type=Images&_token=',
    filebrowserBrowseUrl: 'laravel-filemanager?type=Files',
    filebrowserUploadUrl: 'laravel-filemanager/upload?type=Files&_token=',
    customConfig: 'custom/descripcioncorta.js'
});


  CKEDITOR.replace('descripcionlarga',{
    filebrowserImageBrowseUrl: 'laravel-filemanager?type=Images',
    filebrowserImageUploadUrl: 'laravel-filemanager/upload?type=Images&_token=',
    filebrowserBrowseUrl: 'laravel-filemanager?type=Files',
    filebrowserUploadUrl: 'laravel-filemanager/upload?type=Files&_token=',
    customConfig: 'config.js'
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