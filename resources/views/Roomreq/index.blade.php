@extends('app')
  @section('content')

  <div class="row">
    <div class="col-md-12">
      <h1>Roomreq</h1>
    </div>
  </div>

  <div class="form-group row add">
    <div class="col-md-5">
      <input type="text" class="form-control" id="patient_id" name="patient_id"
      placeholder="Your patient_id Here" required>
      <p class="error text-center alert alert-danger hidden"></p>
    </div>
    <div class="col-md-5">
      <input type="text" class="form-control" id="patient_name" name="patient_name"
      placeholder="Your patient_name Here" required>
      <p class="error text-center alert alert-danger hidden"></p>
    </div>
    <div class="col-md-5">
      <input type="text" class="form-control" id="patient_blood" name="patient_blood"
      placeholder="Your patient_blood Here" required>
      <p class="error text-center alert alert-danger hidden"></p>
    </div>
    <div class="col-md-5">
      <input type="text" class="form-control" id="patient_blood_type" name="patient_blood_type"
      placeholder="Your patient_blood_type Here" required>
      <p class="error text-center alert alert-danger hidden"></p>
    </div>
    <div class="col-md-5">
      <input type="text" class="form-control" id="patient_detail" name="patient_detail"
      placeholder="Your patient_detail Here" required>
      <p class="error text-center alert alert-danger hidden"></p>
    </div>
    <div class="col-md-5">
      <input type="text" class="form-control" id="patient_province" name="patient_province"
      placeholder="Your patient_province Here" required>
      <p class="error text-center alert alert-danger hidden"></p>
    </div>
    <div class="col-md-5">
      <input type="text" class="form-control" id="patient_hos" name="patient_hos"
      placeholder="Your patient_hos Here" required>
      <p class="error text-center alert alert-danger hidden"></p>
    </div>
    <div class="col-md-5">
      <input type="text" class="form-control" id="patient_hos_la" name="patient_hos_la"
      placeholder="Your patient_hos_la Here" required>
      <p class="error text-center alert alert-danger hidden"></p>
    </div>
    <div class="col-md-5">
      <input type="text" class="form-control" id="patient_hos_long" name="patient_hos_long"
      placeholder="Your patient_hos_long Here" required>
      <p class="error text-center alert alert-danger hidden"></p>
    </div>
    <div class="col-md-5">
      <input type="text" class="form-control" id="patient_thankyou" name="patient_thankyou"
      placeholder="Your patient_thankyou Here" required>
      <p class="error text-center alert alert-danger hidden"></p>
    </div>
    <div class="col-md-5">
      <input type="text" class="form-control" id="countblood" name="countblood"
      placeholder="Your countblood Here" required>
      <p class="error text-center alert alert-danger hidden"></p>
    </div>
    <div class="col-md-2">
      <button class="btn btn-warning" type="submit" id="add">
        <span class="glyphicon glyphicon-plus"></span> Add New Data
      </button>
    </div>
  </div>

  <div class="row">
    <div class="table-responsive">
      <table class="table table-borderless" id="table">
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
      </table>
    </div>
  </div>


  <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" role="form">
            <div class="form-group">
              <label class="control-label col-sm-4" for="id">ID :</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="Reid" disabled>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-4" for="Reuid">user_id:</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="Reuid">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-4" for="title">Title:</label>
              <div class="col-sm-8">
                <input type="name" class="form-control" id="t">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-4" for="patient_id">patient_id:</label>
              <div class="col-sm-8">
                <input type="name" class="form-control" id="d">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-4" for="patient_status">patient_status:</label>
              <div class="col-sm-8">
                <input type="name" class="form-control" id="d">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-4" for="patient_name">patient_name:</label>
              <div class="col-sm-8">
                <input type="name" class="form-control" id="d">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-sm-4" for="patient_blood">patient_blood:</label>
              <div class="col-sm-8">
                <input type="name" class="form-control" id="d">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-4" for="patient_blood_type">patient_blood_type:</label>
              <div class="col-sm-8">
                <input type="name" class="form-control" id="d">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-4" for="patient_detail">patient_detail:</label>
              <div class="col-sm-8">
                <input type="name" class="form-control" id="d">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-4" for="patient_province">patient_province:</label>
              <div class="col-sm-8">
                <input type="name" class="form-control" id="d">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-4" for="patient_hos">patient_hos:</label>
              <div class="col-sm-8">
                <input type="name" class="form-control" id="d">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-4" for="patient_hos_la">patient_hos_la:</label>
              <div class="col-sm-8">
                <input type="name" class="form-control" id="d">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-4" for="patient_hos_long">patient_hos_long:</label>
              <div class="col-sm-8">
                <input type="name" class="form-control" id="d">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-4" for="patient_thankyou">patient_thankyou:</label>
              <div class="col-sm-8">
                <input type="name" class="form-control" id="d">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-4" for="countblood">countblood:</label>
              <div class="col-sm-8">
                <input type="name" class="form-control" id="d">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-4" for="count_refresh">count_refresh:</label>
              <div class="col-sm-8">
                <input type="name" class="form-control" id="d">
              </div>
            </div>

          </form>
            <div class="deleteContent">
            Are you Sure you want to delete <span class="title"></span> ?
            <span class="hidden id"></span>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn actionBtn" data-dismiss="modal">
              <span id="footer_action_button" class='glyphicon'> </span>
            </button>
            <button type="button" class="btn btn-warning" data-dismiss="modal">
              <span class='glyphicon glyphicon-remove'></span> Close
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
      // Edit Data (Modal and function edit data)
      $(document).on('click', '.edit-modal', function() {
        $('#footer_action_button').text(" Update");
        $('#footer_action_button').addClass('glyphicon-check');
        $('#footer_action_button').removeClass('glyphicon-trash');
        $('.actionBtn').addClass('btn-success');
        $('.actionBtn').removeClass('btn-danger');
        $('.actionBtn').addClass('edit');
        $('.modal-title').text('Edit');
        $('.deleteContent').hide();
        $('.form-horizontal').show();
        $('#Reid').val($(this).data('id'));
        $('#Reuid').val($(this).data('Reuid'));
        $('#Repid').val($(this).data('Repids'));
        $('#Repstatus').val($(this).data('Repstatuss'));
        $('#Repname').val($(this).data('Repnames'));
        $('#Repblood').val($(this).data('Repbloods'));
        $('#Repbloodtype').val($(this).data('Repbloodtypes'));
        $('#Repdetail').val($(this).data('Repdetails'));
        $('#Repprovince').val($(this).data('Repprovinces'));
        $('#Rephos').val($(this).data('Rephoss'));
        $('#Rephosla').val($(this).data('Rephoslas'));
        $('#Rephoslong').val($(this).data('Rephoslongs'));
        $('#Repthank').val($(this).data('Repthanks'));
        $('#Recblood').val($(this).data('Recbloods'));
        $('#Recrefresh').val($(this).data('Recrefreshs'));
        $('#Recat').val($(this).data('Recats'));
        $('#Reuat').val($(this).data('Reuats'));

        $('#t').val($(this).data('title'));
        $('#d').val($(this).data('description'));
        $('#myModal').modal('show');
    });
    $('.modal-footer').on('click', '.edit', function() {
    $.ajax({
        type: 'post',
        url: '/editItem',
        data: {
            '_token': $('input[name=_token]').val(),
            // 'id': $("#Reid").val(),
            'Reuids': $("#Reuid").val(),
            'Repids': $("#Repid").val(),
            'Repstatuss': $("#Repstatus").val(),
            'Repnames': $("#Repname").val(),
            'Repbloods': $("#Repblood").val(),
            'Repbloodtypes': $("#Repbloodtype").val(),
            'Repdetails': $("#Repdetail").val(),
            'Repprovinces': $("#Repprovince").val(),
            'Rephoss': $("#Rephos").val(),
            'Rephoslas': $("#Rephosla").val(),
            'Rephoslongs': $("#Rephoslong").val(),
            'Repthanks': $("#Repthank").val(),
            'Recbloods': $("#Recblood").val(),
            'Recrefreshs': $("#Recrefresh").val(),
            'Recats': $("#Recat").val(),
            'Reuats': $("#Reuat").val(),
        },
        success: function(data) {

        }
    });
  });
  // add function
  $("#add").click(function() {
    $.ajax({
      type: 'post',
      url: '/addItem',
      data: {
        '_token': $('input[name=_token]').val(),
        // 'title': $('input[name=title]').val(),
        // 'description': $('input[name=description]').val(),
        'Repid': $('input[name=Repid]').val(),
        'Repstatus': $('input[name=Repstatus]').val(),
        'Repname': $('input[name=Repname]').val(),
        'Repblood': $('input[name=Repblood]').val(),
        'Repbloodtype': $('input[name=Repbloodtype]').val(),
        'Repdetail': $('input[name=Repdetail]').val(),
        'Repprovince': $('input[name=Repprovince]').val(),
        'Rephos': $('input[name=Rephos]').val(),
        'Rephosla': $('input[name=Rephosla]').val(),
        'Rephoslong': $('input[name=Rephoslong]').val(),
        'Repthank': $('input[name=Repthank]').val(),
        'Recblood': $('input[name=Recblood]').val(),
        'Recrefresh': $('input[name=Recrefresh]').val(),
        'Recat': $('input[name=Recat]').val(),
        'Reuat': $('input[name=Reuat]').val(),
      },
      success: function(data) {
        if ((data.errors)) {
          $('.error').removeClass('hidden');
          $('.error').text(data.errors.title);
          $('.error').text(data.errors.description);
        } else {
          $('.error').remove();
          $('#table').append("<tr class='item" + data.id + "'><td>" + data.id + "</td><td>" + data.Reuid + "</td><td>" + data.title + "</td><td>" + data.description + "</td><td><button class='edit-modal btn btn-info' data-id='" + data.id + "' data-Reuid='" + data.Reuid + "' data-title='" + data.title + "' data-description='" + data.description + "'><span class='glyphicon glyphicon-edit'></span> Edit</button> <button class='delete-modal btn btn-danger' data-id='" + data.id + "' data-title='" + data.title + "' data-description='" + data.description + "'><span class='glyphicon glyphicon-trash'></span> Delete</button></td></tr>");
        }
      },
    });
    $('#title').val('');
    $('#description').val('');
  });

  //delete function
  $(document).on('click', '.delete-modal', function() {
    $('#footer_action_button').text(" Delete");
    $('#footer_action_button').removeClass('glyphicon-check');
    $('#footer_action_button').addClass('glyphicon-trash');
    $('.actionBtn').removeClass('btn-success');
    $('.actionBtn').addClass('btn-danger');
    $('.actionBtn').addClass('delete');
    $('.modal-title').text('Delete');
    $('.id').text($(this).data('id'));
    $('.deleteContent').show();
    $('.form-horizontal').hide();
    $('.title').html($(this).data('title'));
    $('#myModal').modal('show');
  });

  $('.modal-footer').on('click', '.delete', function() {
    $.ajax({
      type: 'post',
      url: '/deleteItem',
      data: {
        '_token': $('input[name=_token]').val(),
        'id': $('.id').text()
      },
      success: function(data) {
        $('.item' + $('.id').text()).remove();
      }
    });
  });

  </script>

  {{-- <tr class='item" + data.id + "'><td>" + data.id + "</td><td>" + data.Reuid + "</td><td>" + data.Repid + "</td><td>" + data.Repstatus + "</td><td>" + data.Repname + "</td><td>" + data.Repblood + "</td><td>" + data.Repbloodtype + "</td><td>" + data.Repdetail + "</td><td>" + data.Repprovince + "</td><td>" + data.Rephos + "</td><td>" + data.Rephosla + "</td><td>" + data.Rephoslong + "</td><td>" + data.Repthank + "</td> <td>" + data.Recblood + "</td><td>" + data.Recrefresh + "</td><td>" + data.Recat + "</td><td>" + data.Reuat + "</td><td><button class='edit-modal btn btn-info' data-id='" + data.id + "' data-title='" + data.title + "' data-description='" + data.description + "' data-user-id='" + data.Reuid + "' data-patient-status='" + data.Repid + "' data-patient-id='" + data.Repstatus + "' data-patient-name='" + data.Repname + "' data-patient-blood='" + data.Repblood + "' data-patient-blood_type='" + data.Repbloodtype + "' data-patient-detail='" + data.Repdetail + "' data-patient-province='" + data.Repprovince + "' data-patient-hos='" + data.Rephos + "' data-patient-hos-la='" + data.Rephosla + "' data-patient-hos-long='" + data.Rephoslong + "' data-patient-thankyou='" + data.Repthank + "' data-countblood='" + data.Recblood + "' data-count-refresh='" + data.Recrefresh + "' data-created-at='" + data.Recat + "' data-updated-at='" + data.Reuat + "'><span class='glyphicon glyphicon-edit'></span> Edit </button>
        {{-- <button class='delete-modal btn btn-danger'
                  data-id='" + data.id + "'
                  data-title='" + data.title + "'
                  data-description='" + data.description + "'
                  data-user-id='" + data.Reuid + "'
                  data-patient-status='" + data.Repid + "'
                  data-patient-id='" + data.Repstatus + "'
                  data-patient-name='" + data.Repname + "'
                  data-patient-blood='" + data.Repblood + "'
                  data-patient-blood_type='" + data.Repbloodtype + "'
                  data-patient-detail='" + data.Repdetail + "'
                  data-patient-province='" + data.Repprovince + "'
                  data-patient-hos='" + data.Rephos + "'
                  data-patient-hos-la='" + data.Rephosla + "'
                  data-patient-hos-long='" + data.Rephoslong + "'
                  data-patient-thankyou='" + data.Repthank + "'
                  data-countblood='" + data.Recblood + "'
                  data-count-refresh='" + data.Recrefresh + "'
                  data-created-at='" + data.Recat + "'
                  data-updated-at='" + data.Reuat + "'
              ><span class='glyphicon glyphicon-trash'></span> Delete
        </button>
      </td>
  </tr> --}}
  @stop
