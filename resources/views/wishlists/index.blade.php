<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('titile', config('app.name'))</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/js/app.js','resources/sass/app.scss'])
    <style>
      body,  .container, .card{
        background:#fff;
      }
      .pointer{
        cursor:pointer;
      }
      .active_list{
        border:5px solid #0d6efd !important;
      }
    </style>
  </head>
  <body>
    <div id="app" class="container">
      <div class="row justify-content-center p-5">
        <div class="card">
          <div class="card-body">
            <a href="#" class="btn btn-primary float-end"> <i class="fa fa-plus"></i></a>
          </div>
        </div>

        <div class="card my-5">
          <div class="card-body">
            <h3 class="fw-bold">WishList Collection</h3>
            <div class="col-md-12">
              <ul class="nav nav-tabs mb-3" id="tabs" role="tablist">
                <li class="nav-item" role="presentation">
                  <a
                    class="nav-link active"
                    id="active-tabs-1"
                    data-bs-toggle="tab"
                    href="#active-tab"
                    role="tab"
                    aria-controls="active-tabs-1"
                    aria-selected="true"
                    >Active</a
                  >
                </li>
                <li class="nav-item" role="presentation">
                  <a
                    class="nav-link"
                    id="archived-tabs-2"
                    data-bs-toggle="tab"
                    href="#archived-tab"
                    role="tab"
                    aria-controls="archived-tabs-2"
                    aria-selected="false"
                    >Archived</a
                  >
                </li>
              </ul>
              <div class="tab-content" id="wish-content">
                <div
                  class="tab-pane fade show active"
                  id="active-tab"
                  role="tabpanel"
                  aria-labelledby="active-tab"
                >
                  <div class="col-md-12">
                    <div class="row my-3 py-3">
                      @foreach($wishlists as $list)
                        <div class="col-sm-2 mx-2 border border-3 pointer" @click="set_current_list({{ $list->id }}, '{{ $list->name }}')" :class="current_list_id == {{ $list->id }} ? active_list : ''">
                          <img src="{{ asset('images/icon.png') }}" class="img-fluid d-block text-center">
                          <h5 class="pt-2 d-inline">{{ $list->name }}</h5>
                          <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#edit_wishlist-{{ $list->id }}" class="bg-primary rounded-circle float-end p-1 ml-3"><i class="fa fa-pencil text-white"></i></a>

                          {{-- Edit Current List --}}
                          <div class="modal fade" id="edit_wishlist-{{ $list->id }}" tabindex="-1" aria-labelledby="edit_wishlistModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="add_wishlistModalLabel">Update Wishlist</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  <form method="POST" action="{{ route('wishlist.update',$list) }}">
                                    @csrf
                                    @method('PATCH')
                                    <div class="mb-3">
                                      <label for="exampleFormControlInput1" class="form-label">Wishlist Name</label>
                                      <input type="text" class="form-control @error('name') is-invalid @enderror" id="list_name" value="{{ old('name', $list->name) }}" required name="name">
                                      @error('name')
                                        <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                        </span>
                                      @enderror
                                    </div>
                                    <div class="mb-3">
                                      <button type="submit" class="btn btn-primary">Update Wishlist</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                          </div>
                          <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#del_wishlist-{{ $list->id }}" class="bg-primary rounded-circle float-end p-1 mx-2"><i class="fa fa-trash text-danger"></i></a>

                          {{-- Remove Current List --}}
                          <div class="modal fade" id="del_wishlist-{{ $list->id }}" tabindex="-1" aria-labelledby="del_wishlistModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="add_wishlistModalLabel">Remove Wishlist</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  <form method="POST" action="{{ route('wishlist.destroy',$list) }}">
                                    <p class="text-danger text-center">Please Note that this action is not reversible!</p>
                                    @csrf
                                    @method('DELETE')
                                    <div class="mb-3">
                                      <button type="submit" class="btn btn-danger">Remove Wishlist</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      @endforeach
                      {{-- Add new wishlist --}}
                      <div class="col-sm-2 pt-5">
                        <a href="#" class="bg-light p-5"  data-bs-toggle="modal" data-bs-target="#add_wishlist"><i class="fa fa-plus fa-2x text-primary"></i></a>
                      </div>
                    </div>
                    {{-- wish list items --}}
                    <div class="row justify-content-between mt-5">
                      <div class="col-sm-4">
                        <div class="row">
                          <div class="col-sm-8">
                            <input type="text" class="form-control" placeholder=" &#xF002; search" style="font-family:Arial, FontAwesome" >
                          </div>
                          <div class="col-sm-4">
                            <button class="btn btn-primary">Search</button>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-3" v-if="current_list_id">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_wishlist_item">Add Items to: <span class="fw-bolder">@{{ current_list_name }}</span></button>
                      </div>
                      <div class="col-sm-5">
                        <div class="row">
                          <div class="col-sm-4">
                            <select class="form-select">
                              <option>Shops: All</option>
                            </select>
                          </div>
                          <div class="col-sm-4">
                            <select class="form-select">
                              <option>Price: All</option>
                            </select>
                          </div>
                          <div class="col-sm-4">
                            <select class="form-select">
                              <option>Date</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12 mt-5">
                        <div class="row">
                          <div class="form-check col-sm-1">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                              Select
                            </label>
                          </div>
                          <div class="col-sm-2">
                            <i class="fa fa-trash"></i>
                          </div>
                        </div>
                        <table class="table table-bordered table-light">
                          <tbody>
                            <tr v-for="item in items" class="py-3">
                              <td>
                                <div class="form-check col-sm-1">
                                  <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault-">
                                </div>
                              </td>
                              <td><img :src="item.image_url" width="200"> </td>
                              <td>
                                <div>
                                  <h5>@{{ item.name }}</h5>
                                  <p>@{{ item.description }}</p>
                                  <div class="row">
                                    <div class="col-sm-2">
                                      <h5>Price:</h5>
                                      <span>@{{ item.price }}</span>
                                    </div>
                                    <div class="col-sm-2">
                                      <h5>Quantity</h5>
                                      <span>@{{ item.quantity }}</span>
                                      
                                    </div>
                                    <div class="col-sm-2">
                                      <h5>Shop</h5>
                                      <span>@{{ item.shop }}</span>
                                      
                                    </div>
                                    <div class="col-sm-3">
                                      <span class="mt-4 p-2 badge rounded-pill bg-primary">Most Desired</span>
                                    </div>
                                  </div>
                                </div>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="archived-tab" role="tabpanel" aria-labelledby="archived-tab">
                  Archived Content
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Add new Wish List Modal -->
      <div class="modal fade" id="add_wishlist" tabindex="-1" aria-labelledby="add_wishlistModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="add_wishlistModalLabel">Add New Wishlist</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form method="POST" action="{{ route('wishlist.store') }}">
                @csrf
                <div class="mb-3">
                  <label for="exampleFormControlInput1" class="form-label">Wishlist Name</label>
                  <input type="text" class="form-control @error('name') is-invalid @enderror" id="list_name" placeholder="Birthday" required name="name">
                  @error('name')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <div class="mb-3">
                  <button type="submit" class="btn btn-primary">Add Wishlist</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Add items Wish List Modal -->
      <div class="modal fade" id="add_wishlist_item" tabindex="-1" aria-labelledby="add_wishlistModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="add_wishlistModalLabel">Add New Item to Wishlist</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form method="POST" action="{{ route('wishlist_items.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="wish_list_id" :value=" current_list_id">

                <div class="mb-3">
                  <label for="exampleFormControlInput1" class="form-label">Item Name</label>
                  <input type="text" class="form-control @error('name') is-invalid @enderror" id="list_name" placeholder="Cake" required name="name">
                  @error('name')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <div class="mb-3">
                  <label for="exampleFormControlInput1" class="form-label">Item Name</label>
                  <textarea name="description" class="form-control @error('description') is-invalid @enderror" required name="description"></textarea>
                  @error('description')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <div class="mb-3">
                  <label for="exampleFormControlInput1" class="form-label">Item Quantity</label>
                  <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="list_name" required name="quantity">
                  @error('quantity')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <div class="mb-3">
                  <label for="exampleFormControlInput1" class="form-label">Item Price</label>
                  <input type="number" class="form-control @error('price') is-invalid @enderror" id="list_name" required name="price">
                  @error('price')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <div class="mb-3">
                  <label for="exampleFormControlInput1" class="form-label">Item Shop</label>
                  <input type="text" class="form-control @error('shop') is-invalid @enderror"  required name="shop">
                  @error('shop')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <div class="mb-3">
                  <label for="exampleFormControlInput1" class="form-label">Item Image</label>
                  <input type="file" class="form-control @error('image') is-invalid @enderror"  name="image">
                  @error('image')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <div class="mb-3">
                  <button type="submit" class="btn btn-primary">Add Item to Wishlist</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>


    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>
      @if(session('success'))
        swal("Success", "{{ session('success') }}", "success");
      @endif

      @if(session('error'))
        swal("Error", "{{ session('error') }}", "error");
      @endif

      @if(session('info'))
        swal("Info", "{{ session('info') }}", "info");
      @endif

      @if(session('warning'))
        swal("Warning", "{{ session('warning') }}", "warning");
      @endif
    </script>
     @yield('js')
  </body>
</html>
                    