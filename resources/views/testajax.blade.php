@extends('app')
  @section('content')

     {{-- <button id='ajax1'>Ajax1</button>
    <span id='txt1'></span></br>
    <button id='ajax2'>Ajax2</button>
    <span id='txt2'></span></br>
    <button id='ajax3'>Ajax3</button>
    <span id='txt3'></span></br>
    <button id='ajax4'>Ajax4</button>
    <table id='txt4' class="table table-hover">

    </table> --}}

    <!-- Nav tabs -->
     <ul class="nav nav-tabs" role="tablist">
       <li role="presentation" class="active"><a href="#home" role="tab" data-toggle="tab" id="ajax1">ajax1</a></li>
       <li role="presentation"><a href="#profile"  role="tab" data-toggle="tab" id="ajax2">ajax2</a></li>
       <li role="presentation"><a href="#messages" role="tab" data-toggle="tab" id="ajax3">ajax3</a></li>
       <li role="presentation"><a href="#settings"  role="tab" data-toggle="tab" id="ajax4">ajax4</a></li>
     </ul>

     <!-- Tab panes -->
     <div class="tab-content">
       <div role="tabpanel" class="tab-pane active" id="home">
         <div class="box">
             <a class="button" href="#popup1">Let me Pop up</a>
         </div>

         <div id="popup1" class="overlay1">
             <div class="popup1">
                 <h2>Here i am</h2>
                 <a class="close" href="#">&times;</a>
                 <div class="content">
                     Thank to pop me out of that button, but now i'm done so you can close this window.
                 </div>
             </div>
         </div>
         <span id='tbtxt1'></span></br>
       </div>
       <div role="tabpanel" class="tab-pane" id="profile">
         <div class="box">
             <a class="button" href="#popup2">Let me Pop up</a>
         </div>

         <div id="popup2" class="overlay2">
             <div class="popup2">
                 <h2>Here i am</h2>
                 <a class="close" href="#">&times;</a>
                 <div class="content">
                     Thank to pop me out of that button, but now i'm done so you can close this window.
                 </div>
             </div>
         </div>
         <span id='tbtxt2'></span></br>
       </div>
       <div role="tabpanel" class="tab-pane" id="messages">
         <div class="box">
             <a class="button" href="#popup3">Let me Pop up</a>
         </div>

         <div id="popup3" class="overlay3">
             <div class="popup3">
                 <h2>Here i am</h2>
                 <a class="close" href="#">&times;</a>
                 <div class="content">
                     Thank to pop me out of that button, but now i'm done so you can close this window.
                 </div>
             </div>
         </div>
         <span id='tbtxt3'></span></br>
       </div>
       <div role="tabpanel" class="tab-pane" id="settings">
         <div class="box">
             <a class="button" href="#popup4add">Create</a>
         </div>


         <div id="popup4add" class="overlay4">
             <div class="popup4">
                 <h2>Create user</h2>
                 <a class="close" href="#">&times;</a>
                 <div class="content">
                   <form class="form-horizontal">
                    <div class="form-group"><br/>
                      <label for="inputEmail3" class="col-sm-4 control-label">Name</label>
                        <div class="col-sm-8">
                          <input type="email" class="form-control" id="inputuser-name" placeholder="Name">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputPassword3" class="col-sm-4 control-label">Password</label>
                        <div class="col-sm-8">
                          <input type="password" class="form-control" id="inputuser-pass" placeholder="Password">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputPassword3" class="col-sm-4 control-label">Email</label>
                        <div class="col-sm-8">
                          <input type="password" class="form-control" id="inputuser-email" placeholder="Email">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputPassword3" class="col-sm-4 control-label">Blood</label>
                        <div class="col-sm-8">
                          <input type="password" class="form-control" id="inputuser-blood" placeholder="Blood">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputPassword3" class="col-sm-4 control-label">Password</label>
                        <div class="col-sm-8">
                          <input type="password" class="form-control" id="inputPassword3" placeholder="Password">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputPassword3" class="col-sm-4 control-label">Bloodtype</label>
                        <div class="col-sm-8">
                          <input type="password" class="form-control" id="inputuser-bloodtype" placeholder="Bloodtype">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputPassword3" class="col-sm-4 control-label">Birthyear</label>
                        <div class="col-sm-8">
                          <input type="password" class="form-control" id="inputuser-birthyear" placeholder="Birthyear">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputPassword3" class="col-sm-4 control-label">Firstname</label>
                        <div class="col-sm-8">
                          <input type="password" class="form-control" id="inputuser-firstname" placeholder="Firstname">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputPassword3" class="col-sm-4 control-label">Lastname</label>
                        <div class="col-sm-8">
                          <input type="password" class="form-control" id="inputuser-lastname" placeholder="Lastname">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputPassword3" class="col-sm-4 control-label">Phone</label>
                        <div class="col-sm-8">
                          <input type="password" class="form-control" id="inputuser-phone" placeholder="Phone">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputPassword3" class="col-sm-4 control-label">Province</label>
                        <div class="col-sm-8">
                          <input type="password" class="form-control" id="inputuser-province" placeholder="Province">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputPassword3" class="col-sm-4 control-label">last_date_donate</label>
                        <div class="col-sm-8">
                          <input type="password" class="form-control" id="inputuser-lastdonate" placeholder="last_date_donate">
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                          <button type="submit" class="btn btn-default">Register</button>
                        </div>
                      </div>
                    </form>
                 </div>
             </div>
         </div>
         <div id="popup4edit" class="overlay4">
             <div class="popup4">
                 <h2>Edit</h2>
                 <a class="close" href="#">&times;</a>
                 <div class="content">
                   <form class="form-horizontal">
                    <div class="form-group"><br/>
                      <label for="inputEmail3" class="col-sm-4 control-label">Name</label>
                        <div class="col-sm-8">
                          <input type="email" class="form-control" id="inputuser-name" placeholder="Name" value="{{ old('name', $data->name)}}">>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputPassword3" class="col-sm-4 control-label">Password</label>
                        <div class="col-sm-8">
                          <input type="password" class="form-control" id="inputuser-pass" placeholder="Password">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputPassword3" class="col-sm-4 control-label">Email</label>
                        <div class="col-sm-8">
                          <input type="password" class="form-control" id="inputuser-email" placeholder="Email">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputPassword3" class="col-sm-4 control-label">Blood</label>
                        <div class="col-sm-8">
                          <input type="password" class="form-control" id="inputuser-blood" placeholder="Blood">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputPassword3" class="col-sm-4 control-label">Password</label>
                        <div class="col-sm-8">
                          <input type="password" class="form-control" id="inputPassword3" placeholder="Password">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputPassword3" class="col-sm-4 control-label">Bloodtype</label>
                        <div class="col-sm-8">
                          <input type="password" class="form-control" id="inputuser-bloodtype" placeholder="Bloodtype">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputPassword3" class="col-sm-4 control-label">Birthyear</label>
                        <div class="col-sm-8">
                          <input type="password" class="form-control" id="inputuser-birthyear" placeholder="Birthyear">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputPassword3" class="col-sm-4 control-label">Firstname</label>
                        <div class="col-sm-8">
                          <input type="password" class="form-control" id="inputuser-firstname" placeholder="Firstname">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputPassword3" class="col-sm-4 control-label">Lastname</label>
                        <div class="col-sm-8">
                          <input type="password" class="form-control" id="inputuser-lastname" placeholder="Lastname">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputPassword3" class="col-sm-4 control-label">Phone</label>
                        <div class="col-sm-8">
                          <input type="password" class="form-control" id="inputuser-phone" placeholder="Phone">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputPassword3" class="col-sm-4 control-label">Province</label>
                        <div class="col-sm-8">
                          <input type="password" class="form-control" id="inputuser-province" placeholder="Province">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputPassword3" class="col-sm-4 control-label">last_date_donate</label>
                        <div class="col-sm-8">
                          <input type="password" class="form-control" id="inputuser-lastdonate" placeholder="last_date_donate">
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                          <button type="submit" class="btn btn-default">Register</button>
                        </div>
                      </div>
                    </form>
                 </div>
             </div>
         </div>
         <div id="popup4del" class="overlay4">
             <div class="popup4">
                 <h2>Here i am</h2>
                 <a class="close" href="#">&times;</a>
                 <div class="content">
                     Thank to pop me out of that button, but now i'm done so you can close this window.
                 </div>
             </div>
         </div>
         <table id='tbtxt4' class="table table-hover"></table></br>
       </div>
     </div>





<script src="js/testajax.js"></script>
<link rel="stylesheet" href="css/testajax.css">
@stop
