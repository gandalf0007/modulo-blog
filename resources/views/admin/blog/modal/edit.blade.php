@foreach($posts as $post)
<div class="modal fade" id="edit-{{ $post->id }}" tabindex="-1" role="dialog" aria-labelledby="confirmDelete">
 <div class="modal-dialog modal-lg" role="document">
     <div class="modal-content">
         <div class="modal-header">
         	<h4 class="modal-title">Editar Post {{$post->titulo}}</h4>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
         </div>


{{ Form::model($post, array('url' => array('blog-update', $post->id), 'method' => 'PUT', 'files'=>True)) }}
<div class="modal-body">   
@include('admin.blog.forms.edit')
</div>

<div class="modal-footer">
<button type="submit" class="btn btn-success">Modificar</button>
<button type="button" class="btn btn-primary pull-left" data-dismiss="modal">Close</button>
{!!Form::close()!!}
</div>


     </div>
   </div>
 </div>
	@endforeach