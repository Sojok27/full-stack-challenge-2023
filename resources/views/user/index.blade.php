@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>Users
                        <button class="btn btn-info" style="float:right;" data-toggle="modal" data-target="#addUserModal">Add user</button>
                    </h1>
                </div>

                <div class="panel-body">
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif
                    @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <table class="table table-responsive">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                        <script>
                            window.comments = {};
                            window.currentUser = {};
                            currentUser.name = "{{Auth::user()->name}}";
                        </script>
                        @foreach($users as $user)
                        <script>
                        </script>
                        <tr>
                            <td>{{ $user->id }} </td>
                            <td>{{ $user->name }} </td>
                            <td>{{ $user->email }} </td>
                            <td> ************ </td>
                            <td>{{ $user->roles()->get()->first()->description }} </td>
                            <td class="expandable">
                                <button type="button" class="btn btn-success" id="edit_{{ $user->id }}" onclick="editUser('{{ $user->id }}')"  data-toggle="modal" data-target="#editUserModal">Edit</button>
                                @if($user->id != 1)
                                <a class="btn btn-danger" id="delete_{{ $user->id }}" href="{{ route('delete-user', $user->id) }}" onclick="return confirm('Are you sure?')? true : event.preventDefault();">Delete</a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>

                <div class="panel-footer">
                    {{ $users->links() }}
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Edit-User-Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="show-editUser-title">Edit user: <span class="show-editUser-title-span"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form" id="comment-form" action="{{ route('update-user') }}" method="POST">
                    <input name="id" value="" id="editid" type="hidden">
                    {{ csrf_field() }}
                    <div class="form-group">
                    <label for="username">Name </label>
                    <input type="text" id="editusername" name="name" class="form-control" placeholder="Name.." />
                </div>
                <div class="form-group">
                    <label for="useremail">Email </label>
                    <input type="text" id="edituseremail" name="email" class="form-control" placeholder="Email.." />
                </div>
                <div class="form-group">
                    <label for="userpassword">Password </label>
                    <input type="text" id="edituserpassword" name="password" class="form-control" placeholder="Password.." />
                </div>
                <div class="form-group">
                    <label for="userpasswordconfirm">Confirm Password </label>
                    <input type="text" id="edituserpasswordconfirm" name="password_confirmation" class="form-control" placeholder="Password.." />
                </div>
                <div class="form-group">
                    <label for="isbanned">Ban /Unban </label>
                    <input type="checkbox" id="edituserisbanned" name="is_banned" class="form-control" placeholder="Password.." />
                </div>
                <div class="form-group">
                    <input type="submit" id="editsubmit"  class="btn btn-submit" placeholder="Submit" value="Save" />
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="closeEditUserModal" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Add-User-Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Create new user account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form" id="comment-form" action="{{ route('store-user') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                    <label for="comment">Name </label>
                    <input type="text" id="username" name="name" class="form-control" placeholder="Name.." />
                </div>
                <div class="form-group">
                    <label for="comment">Email </label>
                    <input type="text" id="useremail" name="email" class="form-control" placeholder="Email.." />
                </div>
                <div class="form-group">
                    <label for="comment">Password </label>
                    <input type="text" id="userpassword" name="password" class="form-control" placeholder="Password.." />
                </div>
                <div class="form-group">
                    <label for="userpasswordconfirm">Confirm Password </label>
                    <input type="text" id="userpasswordconfirm" name="password_confirmation" class="form-control" placeholder="Password.." />
                </div>
                <div class="form-group">
                    <label for="comment">Role </label>
                    <select class="form-control" name="role">
                        <option selected disabled>Select a role</option>
                        @foreach($roles as $role)
                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <input type="submit" id="submit"  class="btn btn-submit" placeholder="Submit" value="Save" />
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" data-dismiss="modal" onclick="saveComment()">Save</button>
            </div>
        </div>
    </div>
</div>


<script>
    const users = JSON.parse(`{!! $usersJson !!}`).data;
    const editUser = (id) => {
        let user = {};
        users.forEach((e, i) => {
            if(id == e.id) user = e; 
        });
        $(".show-editUser-title-span").text(user.name);
        $("#editusername")[0].value = (user.name);
        $("#edituseremail")[0].value = (user.email);
        $("#editid")[0].value = (user.id);
        $("#edituserisbanned")[0].checked = (user.is_banned == 1 ? true : false);
    }
</script>
@endsection