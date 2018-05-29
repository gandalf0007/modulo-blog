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
                          <li class="breadcrumb-item active"><a href="{!! URL::to('/blog-panel') !!}">Blog</a></li>
                          <li class="breadcrumb-item active"><a href="{!! URL::to('/blog-categorias') !!}">Categorias</a></li>
                        </ol>
                    </div>
                </div>





                <div class="row">
                    <div class="col-12">
                        <div class="card">

  <ul class="nav nav-tabs profile-tab" role="tablist">
      <li class="nav-item"> <a class="nav-link " href="{!! URL::to('/blog-panel') !!}" role="tab" aria-expanded="false">Blog</a> </li>
      <li class="nav-item "> <a class="nav-link active" href="{!! URL::to('/blog-categorias') !!}" role="tab" aria-expanded="false">Categorias</a> </li>
      <li class="nav-item "> <a class="nav-link" href="{!! URL::to('/blog-tags') !!}" role="tab" aria-expanded="false">Tags</a> </li>
   </ul>


                            <div class="card-body">



        <h4 class="card-title">
      @can('crear-post')
      <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#nuevo-categoria"><i class="fa fa-plus fa-lg"> </i></button>
      @endcan
      
           </h4>

           



  <!--buscador
{!!Form::open(['url'=>'usuario', 'method'=>'GET' , 'class'=>' form-group  navbar-form' , 'role'=>'Search'])!!}

<div class="row ">

<div class=" col-md-6 m-t-20">
<div class="input-group">
    <span class="input-group-addon" id="basic-addon3"><i class="mdi mdi-rename-box"></i></span>
      <input type="text" name="nombre" class="form-control " id="datepicker" aria-describedby="basic-addon3" placeholder="Ingrese el nombre de la categoria">
  </div>
   </div>


   <div class=" col-md-3 m-t-20">
      <button type="submit" class=" btn btn-success "> BUSCAR </button>
   </div>
  </div>
{!!Form::close()!!}
 endbuscador-->


      <h6 class="card-subtitle"></h6>
      <div class="table-responsive m-t-40">
      <table id="" class="table full-color-table full-inverse-table hover-table" cellspacing="0" width="100%">
               <thead>
    <th>#</th>
    <th>nombre</th>
   
    <th>Operaciones</th>
  </thead>
  @foreach($categorias as $categoria)
<tbody>

    <td>{{ $categoria -> id}}</td>
    <td>{{ $categoria -> nombre }}</td>



<td>
  @can('editar-post')
  <button type="button" class="btn btn-primary btn-lg fa fa-edit" data-toggle="modal" data-target="#edit-{{ $categoria->id }}"></button>
  @endcan


<!--esto es para que solo el administrador pueda eliminar-->
<!--para el metodo eliminar necesito de un formulario para ejecutarlo-->
@can('eliminar-post')
 <button type="button" class="btn btn-danger btn-lg fa fa-trash-o" data-toggle="modal" data-target="#confirmDelete-{{ $categoria->id }}"></button>
@endcan


</td>

  </tbody>
  @endforeach
                        </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>




@include('admin.blog.categorias.modal.create')
@include('admin.blog.categorias.modal.edit')
@include('admin.blog.categorias.modal.delete')




@endsection