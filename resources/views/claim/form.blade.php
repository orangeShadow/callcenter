<div class="row">
    <div class="col-lg-12">
        {{--
        <div class="form-group">
            {!! Form::label('project_id',Lang::get('claim.project'))!!}
            {!! Form::select('project_id',[0=>"-"]+\App\Project::where("status","<>","Z")->get(["id","title"])->lists('title','id'),Request::get('project_id'),['class'=>'form-control']) !!}
        </div>
        --}}
        {!! Form::hidden('project_id',Request::get('project_id')) !!}
        @if($claimType=\App\ClaimType::where('project_id','=',(int)Request::get('project_id'))->get(['id','title'])->lists('title','id'))
        <div class="form-group">
            {!! Form::label('type_request',Lang::get('claim.type_request')) !!}
            {!! Form::select('type_request', $claimType,$claim->type_request,["class"=>"form-control"])!!}
        </div>
        @endif
        <div class="form-group">
            {!! Form::label('name',Lang::get('claim.name')) !!}
            {!!Form::text('name',$claim->name,["class"=>"form-control"])!!}
        </div>
        <div class="form-group">
            {!! Form::label('phone',Lang::get('claim.phone')) !!}
            {!!Form::text('phone',$claim->phone,["class"=>"form-control"])!!}
        </div>

        <div class="form-group">
            {!! Form::label('text',Lang::get('claim.text')) !!}
            @if($claim->project->typicalDescriptions)
                <div class="row">
                    <div class="col-lg-6">
                        <select id="typicalDescriptionSelect" class="form-control">
                            <option>-</option>
                            @foreach($claim->project->typicalDescriptions->sortBy('sort') as $desc)
                                <option value="{{$desc->id}}">{{$desc->description}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-1"><a class="btn btn-default addTypicalDescription"><i class="glyphicon glyphicon-plus"></i></a></div>
                </div>
                <br>
            @endif
            {!! Form::textarea('text',$claim->text,["class"=>"form-control"]) !!}
        </div>
        <div class="form-group">
            {!! Form::label('text',Lang::get('claim.backcall_at')) !!}
            {!! Form::text('backcall_at',$claim->backcall_at,["class"=>"form-control"]) !!}
        </div>
        @foreach($properties as $property)
            <div class="form-group">
                {!! Form::label('title',$property->title) !!}
                @if($property->type=='date')
                    {!! Form::input('text','property['.$property->id.']',Request::get('property['.$property->id.']',$property->value),["class"=>"form-control datepicker"]) !!}
                @else
                    {!! Form::input('text','property['.$property->id.']',Request::get('property['.$property->id.']',$property->value),["class"=>"form-control"]) !!}
                @endif
            </div>
        @endforeach
        @if(isset($createStatus))
            {!! Form::hidden('status','N') !!}
        @else
            <div class="form-group">
                {!! Form::label('status',Lang::get('claim.status')) !!}
                {!! Form::select('status',\App\StatusClaim::orderBy('sort','asc')->get(['code','title'])->lists('title','code'),Request::get('status'),['class'=>'form-control']) !!}
            </div>
        @endif

        <div class="form-group">
            {!! Form::submit($submit,["class"=>"btn btn-default"]) !!}
        </div>
    </div>
</div>