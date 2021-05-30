@extends('layouts.master')
@section('title','Coach Edit')
@section('content')
    <div class="coach-edit">
      <form action="">
        
        <div class="container">
          <div class="row">
            <div class="col-md-10">
              <div class="row">
                <div class="img-upload mb-4">
                  <input accept="image/*" type='file' id="imgInp" />
                  <img id="blah" src="{{ asset('/img/download.png')}}" alt="your image" />
                  <i class="bi bi-plus-lg"></i>
                </div>
                <h2>Basic information</h2>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" aria-describedby="emailHelp" >
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="family">Family name</label>
                    <input type="text" class="form-control" id="family" aria-describedby="emailHelp">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="province">Province</label>
                    <select class="form-control" id="province">
                      <option>1</option>
                      <option>2</option>
                      <option>3</option>
                      <option>4</option>
                      <option>5</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="form-group">
                    <label for="about">About me</label>
                    <textarea class="form-control" id="about"></textarea>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="province">Province</label>
                    <select class="form-control" id="province">
                      <option>1</option>
                      <option>2</option>
                      <option>3</option>
                      <option>4</option>
                      <option>5</option>
                    </select>
                    <div class="form-check">
                      <input type="checkbox" class="form-check-input" id="exampleCheck1">
                      <label class="form-check-label" for="exampleCheck1">Check me out</label>
                    </div>
                  </div>
                </div>
                <h2>Coach information</h2>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="speciality">Speciality</label>
                    <select class="form-control" id="speciality" multiple="multiple">
                      <option>1</option>
                      <option>2</option>
                      <option>3</option>
                      <option>4</option>
                      <option>5</option>
                    </select>
                    <i class="bi bi-plus-lg"></i>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="experience">Experience</label>
                    <select class="form-control" id="experience">
                      <option>1</option>
                      <option>2</option>
                      <option>3</option>
                      <option>4</option>
                      <option>5</option>
                    </select>
                    <i class="bi bi-chevron-compact-down"></i>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="certificate">Coaching certificate</label>
                    <select class="form-control" id="certificate">
                      <option>1</option>
                      <option>2</option>
                      <option>3</option>
                      <option>4</option>
                      <option>5</option>
                    </select>
                    <i class="bi bi-chevron-compact-down"></i>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="rinks">Rinks</label>
                    <select class="form-control" id="rinks" multiple="multiple" >
                      <option>1</option>
                      <option>2</option>
                      <option>3</option>
                      <option>4</option>
                      <option>5</option>
                    </select>
                    <i class="bi bi-plus-lg"></i>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="language">Language spoken</label>
                    <select class="form-control" id="language" multiple="multiple">
                      <option>1</option>
                      <option>2</option>
                      <option>3</option>
                      <option>4</option>
                      <option>5</option>
                    </select>
                    <i class="bi bi-plus-lg"></i>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="price">Price</label>
                    <select class="form-control" id="price">
                      <option>1</option>
                      <option>2</option>
                      <option>3</option>
                      <option>4</option>
                      <option>5</option>
                    </select>
                    <i class="bi bi-chevron-compact-down"></i>
                  </div>
                </div>
                <h2>Contact</h2>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" class="form-control" id="phone">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="phone">WhatsApp</label>
                    <input type="text" class="form-control" id="phone">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email">
                  </div>
                </div>
                <div class="col-md-4 mb-4">
                  <button type="submit" id="create-camp" class="form-control btn btn-primary submit px-3">Create a camp</button>
                </div>
                <div class="offset-md-4 col-md-4 mb-4">
                  <div class="btn-group">
                    <button type="submit" id="cancel" class="form-control btn btn-primary submit px-3">Cancel</button>
                    <button type="submit" id="save" class="form-control btn btn-primary submit px-3">Save</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
    
@endsection
  