
	{!! Form::model($folder, ['action' => ['Document\FolderAdminController@update', 'id'=>$folder->id], 'method' => 'PUT']) !!}    
		<input type="hidden" name="banner_id" value={{$banner->id}}>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <span class="form-title">Update Folder - {{$folder->name}}</span>
            </div>
            <div class="col-md-1 col-md-offset-1">    
                @if(empty($params))
                    <button class="deleteFolder btn btn-danger" id="{{$folder->id}}">Delete Folder </button>
                @else
                <div class="disabled-button-container" data-toggle="tooltip" data-placement="right"  title="Only empty folders can be deleted">
                    <a class="btn btn-danger" id="{{$folder->id}}" disabled="disabled"  >Delete Folder </a>
                </div>
                @endif
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('name', 'Name') !!}
            {!! Form::text('name', $folder->name, ['class'=>'form-control']) !!}
        </div>

        @if(!empty($params))
            @if ($params["param_name"] == "has_children")
            
                {!! Form::label('Children:') !!}
                @foreach($params["param_value"] as $child)
                    
                    <div class="form-group">
                        {{ $child["name"] }}
                        <a class="btn btn-default editFolder" href="/admin/folder/{{$child['global_folder_id']}}/edit"> Edit </a>
                    </div>

                @endforeach
                <div class="form-group">
                    <button class="btn btn-default addChild">Add Child</button>
                </div>
            
            @elseif($params["param_name"] == "has_weeks")
                <div>
                    <label>
                        <input type="checkbox" name="removeWeeks" value=1 id="removeWeeks">
                        Remove week folders?
                    </label>
                </div>
            @endif
        @else 
            <div >
                
                <button class="btn btn-default" value="addWeek" id="addWeek"> Add Weeks </button>
                <div  id="addWeekContainer"></div>
                <button class="btn btn-default" value="addFolder" id="addFolder"> Add Folder </button>
                <div  id="addFolderContainer"></div>
                
            </div>
        @endif
        <div>
            {!! Form::label('tags[]', 'Tags') !!}
            {!! Form::select('tags[]', $tags, $selected_tags, ['class'=>'chosen', 'multiple'=>'true']) !!}
        </div>
        <div class="row">
            <div class="col-md-4 col-md-offset-4 ">
                {!! Form::submit('Update Folder!', ['class'=> 'form-control btn-success']) !!}
            </div>
        </div>
       

    {!! Form::close() !!}


