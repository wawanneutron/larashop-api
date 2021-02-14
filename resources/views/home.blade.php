@extends('layouts.app')

@section('content')
<div class="container">
  @if (session('success'))
      <div class=" alert alert-success">
        {{ session('success') }}
      </div>
  @elseif (session ('delete'))
       <div class=" alert alert-danger">
        {{ session('delete') }}
      </div>
  @endif
  <div class="data-user">
    <h2>Data Users</h2>
    <table class="mt-3  table  table-responsive-md">
      <tr class=" table-primary">
        <th>#</th>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Roles</th>
        <th>Avatar</th>
        <th>Action</th>
      </tr>
      @foreach($users as $key => $user)
        <tr>
          <td>{{ $key + $users->firstItem() }}</td>
          <td>{{ $user->id }}</td>
          <td>{{ $user->name }}</td>
          <td>{{ $user->email }}</td>
          @foreach (json_decode($user->roles) as $item)
            <td>{{ $item }}</td>    
          @endforeach
          <td>
            @if ($user->avatar)
                <img src="{{ Storage::url($user->avatar) }}" class=" img-thumbnail" width="100">
            @else
              N/A
            @endif
          </td>
          <td>
            <a href="{{ route('update-user', $user->id) }}" class="btn btn-info mr-3 mb-2" data-toggle="modal" data-target="#exampleModal{{ $user->id }}">Edit</a>
            <a href="#" class="btn btn-danger mb-2"  data-toggle="modal" data-target="#modalDelete{{ $user->id }}">Delete</a>
          </td>
      </tr>
      <!-- Vertically centered modal -->
      <div class="modal fade" id="modalDelete{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="modalDelete" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Delete Permanent ?</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              Do you wont to <span class="text-danger text-bold">delete permanent</span> <br> Account User <span class=" font-weight-bold">{{$user->name}}</span> ?
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <form action="{{ route ('user-delete', $user->id) }}" class="d-inline m-2" method="POST">
                @csrf
                @method('delete')
                <button class="btn btn-danger">
                  Delete Permanent
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
      {{-- modal-update --}}
      <div class="modal fade" id="exampleModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModal" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">New message</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="{{ route('update-user', $user->id) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                  <label for="recipient-name" class="col-form-label">Images:</label>
                  <input type="file" name="avatar"  id="recipient-name">
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <input type="submit" class="btn btn-primary" value="Update"></input>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </table>
    {{ $users->links() }}
    

  </div>
  {{-- data buku --}}
  <div class="data-buku mt-5">
      <h2>Data Books</h2>
    <table class="mt-5 table table-responsive-md">
      <tr class=" table-success">
        <th>#</th>
        <th>Title</th>
        <th>Author</th>
        <th>Cover</th>
        <th>Action</th>
      </tr>
      @foreach ($books as $key => $book)
        <tr>
          <td>{{ $key + $books->firstItem() }}</td>
          <td>{{ $book->title }}</td>
          <td>{{ $book->author }}</td>
          <td>
            <img src="{{ Storage::url($book->cover) }}" class=" img-thumbnail" width="100">
          </td>
          <td>
            <a href="{{ route('update-book', $book->id) }}" class="btn btn-info mr-3 mb-2" data-toggle="modal" data-target="#editBook{{ $book->id }}">Edit</a>
            <a href="{{ 'delete-book', $book->id }}" class="btn btn-danger mb-2"  data-toggle="modal" data-target="#deleteBook{{ $book->id }}">Delete</a>
          </td>
        </tr>
         <!-- Vertically centered modal -->
          <div class="modal fade" id="deleteBook{{ $book->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteBook" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Delete Permanent ?</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  Do you wont to <span class="text-danger text-bold">delete permanent</span> <br> Book <span class=" font-weight-bold">{{$book->title}}</span> ?
                  
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <form action="{{ route ('book-delete', $book->id) }}" class="d-inline m-2" method="POST">
                    @csrf
                    @method('delete')
                    <button class="btn btn-danger">
                      Delete Permanent
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          {{-- modal-update --}}
          <div class="modal fade" id="editBook{{ $book->id }}" tabindex="-1" role="dialog" aria-labelledby="editBook" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form action="{{ route('update-book', $book->id) }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                      <label for="recipient-name" class="col-form-label">Images:</label>
                      <input type="file" name="cover"  id="recipient-name">
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <input type="submit" class="btn btn-primary" value="Update"></input>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </table>
      {{ $books->links() }}
  </div>

  {{-- data category --}}
  <div class="categories">
    <h2>Data Category</h2>
    <table class="mt-5 table table-responsive-md">
      <tr class=" table-primary">
        <th>#</th>
        <th>Name</th>
        <th>Image</th>
        <th>Action</th>
      </tr>
      @foreach ($categories as $key => $category)
          <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $category->name }}</td>
            <td>
              <img src="{{ Storage::url($category->image) }}" width="100">
            </td>
            <td>
              <a href="{{ route('update-category', $category->id) }}" class="btn btn-info mr-3 mb-2" data-toggle="modal" data-target="#editCategory{{ $category->id }}">Edit</a>
            </td>
          </tr>
           {{-- modal-update --}}
          <div class="modal fade" id="editCategory{{ $category->id }}" tabindex="-1" role="dialog" aria-labelledby="editCategory" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form action="{{ route('update-category', $category->id) }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                      <label for="recipient-name" class="col-form-label">Images:</label>
                      <input type="file" name="image"  id="recipient-name">
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <input type="submit" class="btn btn-primary" value="Update"></input>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
      @endforeach
    </table>
  </div>
</div>
@endsection

