@extends('app')
  @section('content')
    <div class="row">
		    <div class="col-lg-12">
		        <div class="text-xs-left">
		            <h2>Laravel Ajax CRUD Example</h2>
		        </div>
		        <div class="text-xs-right">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#create-item">
                          Create Item
                    </button>
		        </div>
		    </div>
		</div>

		<table class="table table-bordered">
			<thead>
				<tr>
					<th>options</th>
					<th>id</th>
					<th>user_id</th>
					<th>patient_status</th>
					<th>patient_id</th>
					<th>patient_name</th>
					<th>patient_blood</th>
					<th>patient_blodd_type</th>
					<th>patient_detail</th>
					<th>patient_province</th>
					<th>patient_hos</th>
					<th>patient_hos_la</th>
					<th>patient_hos_long</th>
					<th>patient_thankyou</th>
					<th>countblood</th>
					<th>count_refresh</th>
					<th>created_at</th>
					<th>updated_at</th>
				</tr>
				{{ csrf_field() }}
			</thead>
			<tbody>
				<?php $no=1; ?>
        @foreach($roomreqs as $req)
          <tr class="item{{$req->id}}">
            <td>
              <button class="edit-modal btn btn-primary" data-id="{{$req->id}}" data-Reuid="{{$req->user_id}}">
                <span class="glyphicon glyphicon-edit"></span> Edit
              </button>
              <button class="delete-modal btn btn-danger" data-id="{{$req->id}}" data-Reuid="{{$req->user_id}}">
                <span class="glyphicon glyphicon-trash"></span> Delete
              </button>
            </td>
            <td>{{$req->id}}</td>
            <td>{{$req->user_id}}</td>
            <td>{{$req->patient_status}}</td>
            <td>{{$req->patient_id}}</td>
            <td>{{$req->patient_name}}</td>
            <td>{{$req->patient_blood}}</td>
            <td>{{$req->patient_blood_type}}</td>
            <td>{{$req->patient_detail}}</td>
            <td>{{$req->patient_province}}</td>
            <td>{{$req->patient_hos}}</td>
            <td>{{$req->patient_hos_la}}</td>
            <td>{{$req->patient_hos_long}}</td>
            <td>{{$req->patient_thankyou}}</td>
            <td>{{$req->countblood}}</td>
            <td>{{$req->count_refresh}}</td>
            <td>{{$req->created_at}}</td>
            <td>{{$req->updated_at}}</td>
          </tr>
					@endforeach
			</tbody>
		</table>

		<ul id="pagination" class="pagination-sm"></ul>

	    <!-- Create Item Modal -->
		<div class="modal fade" id="create-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
		        <h4 class="modal-title" id="myModalLabel">Create Item</h4>
		      </div>
		      <div class="modal-body">

		      		<form data-toggle="validator" action="{{ route('adminreq.store') }}" method="POST">
		      			<div class="form-group">
									<label class="control-label" for="title">Title:</label>
									<input type="text" name="title" class="form-control" data-error="Please enter title." required />
									<div class="help-block with-errors"></div>
								</div>
								<div class="form-group">
									<label class="control-label" for="title">Description:</label>
									<textarea name="description" class="form-control" data-error="Please enter description." required></textarea>
									<div class="help-block with-errors"></div>
								</div>
								<div class="form-group">
									<label class="control-label" for="patient_id">patient_id:</label>
									<input type="text" name="patient_id" class="form-control" data-error="Please enter patient_id." required />
									<div class="help-block with-errors"></div>
								</div>
								<div class="form-group">
									<label class="control-label" for="patient_name">patient_name:</label>
									<input type="text" name="patient_name" class="form-control" data-error="Please enter patient_name." required />
									<div class="help-block with-errors"></div>
								</div>
								<div class="form-group">
									<label class="control-label" for="patient_blood">patient_blood:</label>
									<input type="text" name="patient_blood" class="form-control" data-error="Please enter patient_blood." required />
									<div class="help-block with-errors"></div>
								</div>
								<div class="form-group">
									<label class="control-label" for="patient_blood_type">patient_blood_type:</label>
									<input type="text" name="patient_blood_type" class="form-control" data-error="Please enter patient_blood_type." required />
									<div class="help-block with-errors"></div>
								</div>
								<div class="form-group">
									<label class="control-label" for="patient_detail">patient_detail:</label>
									<input type="text" name="patient_detail" class="form-control" data-error="Please enter patient_detail." required />
									<div class="help-block with-errors"></div>
								</div>
								<div class="form-group">
									<label class="control-label" for="patient_hos">patient_hos:</label>
									<input type="text" name="patient_hos" class="form-control" data-error="Please enter patient_hos." required />
									<div class="help-block with-errors"></div>
								</div>
								<div class="form-group">
									<label class="control-label" for="patient_hos_la">patient_hos_la:</label>
									<input type="text" name="patient_hos_la" class="form-control" data-error="Please enter patient_hos_la." required />
									<div class="help-block with-errors"></div>
								</div>
								<div class="form-group">
									<label class="control-label" for="patient_hos_long">patient_hos_long:</label>
									<input type="text" name="patient_hos_long" class="form-control" data-error="Please enter patient_hos_long." required />
									<div class="help-block with-errors"></div>
								</div>
								<div class="form-group">
									<label class="control-label" for="patient_thankyou">patient_thankyou:</label>
									<input type="text" name="patient_thankyou" class="form-control" data-error="Please enter patient_thankyou." required />
									<div class="help-block with-errors"></div>
								</div>
								<div class="form-group">
									<label class="control-label" for="countblood">countblood:</label>
									<input type="text" name="countblood" class="form-control" data-error="Please enter countblood." required />
									<div class="help-block with-errors"></div>
								</div>
								<div class="form-group">
									<label class="control-label" for="count_refresh">count_refresh:</label>
									<input type="text" name="count_refresh" class="form-control" data-error="Please enter count_refresh." required />
									<div class="help-block with-errors"></div>
								</div>
								<div class="form-group">
									<button type="submit" class="btn crud-submit btn-success">Submit</button>
								</div>
		      		</form>
		      </div>
		    </div>
		  </div>
		</div>

		<!-- Edit Item Modal -->
		<div class="modal fade" id="edit-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
		        <h4 class="modal-title" id="myModalLabel">Edit Item</h4>
		      </div>
		      <div class="modal-body">
		      		<form data-toggle="validator" action="{{ route('editreq') }}" method="post">
		      			<div class="form-group">
							<label class="control-label" for="title">Title:</label>
							<input type="text" name="title" class="form-control" data-error="Please enter title." required />
							<div class="help-block with-errors"></div>
						</div>
						<div class="form-group">
							<label class="control-label" for="title">Description:</label>
							<textarea name="description" class="form-control" data-error="Please enter description." required></textarea>
							<div class="help-block with-errors"></div>
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-success crud-submit-edit">Submit</button>
						</div>
		      		</form>
		      </div>
		    </div>
		  </div>
		</div>


  @stop
