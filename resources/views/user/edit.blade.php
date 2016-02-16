@extends('app')

@section('content')
    <h1>{!! Lang::get('user.editUser') !!} {{$user->name}}</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {!! Form::model($user,['method'=>'PATCH','action'=>['UserController@update',$user->id],'class'=>'form-horizontal']) !!}
    <div class="col-lg-12">
        @include('user.form',["submit"=>Lang::get("user.edit")])
    </div>
    {!! Form::close() !!}

    <br>
    <br>
    <h4>Добавить проекты пользователю</h4>
    <div class="col-lg-6">
        {!! Form::open(['method'=>'POST','action'=>['UserController@postProjects',$user->id],'class'=>'form-horizontal','id'=>"formUserProjects"]) !!}
        <div class="form-group">
            <div class="col-lg-8">
                <input id="projectList"  type="text" class="form-control autocomplete">
                <input id="projectValue" type="hidden">
                <input id="projectKey"   type="hidden">
            </div>
            <button class="btn btn-success">+ Добавить</button>
        </div>
        {!! Form::close() !!}
    </div>
    <div class="col-lg-6">
        <h4>Список подключенных проектов</h4>
        <ul id="projectsListUL">
            @foreach($user->projects as $project)
                <li>{{$project->title}} <a href="#" class="removeProject" data-id="{{$project->id}}"   style="color:red; text-decoration: none;">x</a></li>
            @endforeach
        </ul>
    </div>
@stop


@section('scripts')
    <script>
        var projects = {!! json_encode($projects) !!};
        $( "#projectList" ).autocomplete({
            source: projects,
            focus: function() {
                // prevent value inserted on focus
                return false;
            },
            select: function( event, ui ) {
                $( "#projectList" ).val( ui.item.label );
                $( "#projectValue" ).val( ui.item.value );
                var key = projects.findIndex(function(item,index){
                   return item.value ==  ui.item.value;
                });
                $( "#projectKey").val(key);

                return false;
            }
        });

        $("#formUserProjects").submit(function(e){
            e.preventDefault();
            var project_id = $('#projectValue').val();
            var project_key= $('#projectKey').val();
            var project_title = $('#projectList').val();

            if(parseInt(project_id) === NaN || project_id=='' ) {
                alert('Не выбран проект');
                return false
            }

            $.ajax({
                url:$(this).attr('action'),
                method:"POST",
                dataType:"JSON",
                data:{project_id:project_id,_token:$('[name=_token]').val()},
                success:function(xhr){
                    projects.splice(project_key,1);
                    $("#projectsListUL").append('<li>'+project_title+' <a class="removeProject" data-id="'+project_id+'" style="color:red; text-decoration: none;">x</a></li>');
                    $( "#projectList" ).val('');
                    $( "#projectValue" ).val('');
                    $( "#projectKey").val('');

                },
                error:function(xhr){
                    console.log(xhr);
                }
            });
        });

        $(document).on('click','.removeProject',function(e){
            e.preventDefault();
            var li = $(this).parents('li');
            project_id = $(this).data('id');
            $.ajax({
                url:'{{action('UserController@postProjects',$user->id)}}',
                method:'DELETE',
                dataType:'JSON',
                data:{project_id:project_id,_token:$('[name=_token]').val()},
                success:function(xhr){
                    li.remove();
                },
                error:function(xhr){
                    alert("При удалении проекта произошла ошибка");
                }
            });
        });
    </script>
@endsection