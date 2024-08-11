@extends("layouts.app")
@section("title") User Info @endsection
@section("Body")
<style>
.list-group{

    position: absolute;
    left: 0;
    width: 20%;
}
</style>
<div class="row" style="padding-top: 50px 0px">
    <div class="col-3" style="padding-left: 50px">
        <div class="list-group" id="list-tab" role="tablist">
            <a class="list-group-item list-group-item-action active " id="list-home-list"   role="tab" aria-controls="list-home">User Info</a>
            <a class="list-group-item list-group-item-action" id="list-messages-list" href="{{route("profile.ordersIndex")}}" role="tab" aria-controls="list-messages">Orders</a>
        </div>
    </div>
    <div class="col-9" style="padding:120px">
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
                <div class="basic-info-block">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Basic Info</h5>
                            <h6 class="card-subtitle mb-2 text-body-secondary">The basic personal information of the user.</h6>
                            <table class="table">
                                <tbody>
                                    <tr class="row">
                                        <th class="table-item col col-lg-6" scope="row tbl-row">User Name</th>
                                        <td class="table-item col col-lg-6">
                                            <span id="user-name">{{$user->name}}</span>
                                            <button class="btn btn-sm btn-secondary" onclick="toggleEdit('name')">✎</button>
                                            <form id="edit-name-form" action="{{ route('update.name') }}" method="POST" style="display:none;">
                                                @csrf
                                                @method('PUT')
                                                <input type="text" name="name" value="{{ $user->name }}" required>
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <tr class="row">
                                        <th class="table-item col col-lg-6" scope="row tbl-row">Birthday</th>
                                        <td class="table-item col col-lg-6">
                                            <span id="user-birthday">{{ $user->birthday }}</span>
                                            <button class="btn btn-sm btn-secondary" onclick="toggleEdit('birthday')">✎</button>
                                            <form id="edit-birthday-form" action="{{ route('update.birthday') }}" method="POST" style="display:none;">
                                                @csrf
                                                @method('PUT')
                                                <input type="date" name="birthday" value="{{ $user->birthday }}" required>
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <tr class="row">
                                        <th class="table-item col col-lg-6" scope="row tbl-row">Gender</th>
                                        <td class="table-item col col-lg-6">
                                            <span id="user-gender">{{ $user->gender }}</span>
                                            <button class="btn btn-sm btn-secondary" onclick="toggleEdit('gender')">✎</button>
                                            <form id="edit-gender-form" action="{{ route('update.gender') }}" method="POST" style="display:none;">
                                                @csrf
                                                @method('PUT')
                                                <select name="gender" required>
                                                    <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>Male</option>
                                                    <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>Female</option>
                                                </select>
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </form>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <hr />

                <div class="contact-info-block">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Contact Info</h5>
                            <h6 class="card-subtitle mb-2 text-body-secondary">The contact information of the user.</h6>
                            <table class="table">
                                <tbody>
                                    <tr class="row">
                                        <th class="table-item col col-lg-6" scope="row tbl-row">Email</th>
                                        <td class="table-item col col-lg-6">
                                            {{ $user->email }}
                                            <button class="btn btn-sm btn-secondary" onclick="toggleEdit('email')">✎</button>
                                            <form id="edit-email-form" action="{{ route('update.email') }}" method="POST" style="display:none;">
                                                @csrf
                                                @method('PUT')
                                                <input type="text" name="email" value="{{ $user->email }}" required>
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </form>

                                        </td>
                                    </tr>
                                    <tr class="row">
                                        <th class="table-item col col-lg-6" scope="row tbl-row">Phone Number</th>
                                        <td class="table-item col col-lg-6">
                                            {{ $user->phone }}
                                            <button class="btn btn-sm btn-secondary" onclick="toggleEdit('phone')">✎</button>
                                            <form id="edit-phone-form" action="{{ route('update.phone') }}" method="POST" style="display:none;">
                                                @csrf
                                                @method('PUT')
                                                <input type="text" name="phone" value="{{ $user->phone }}" required>
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </form>
                                        </td>

                                    </tr>
                                    @foreach ($user->addresses as $address)
                                    <tr class="row">
                                        <th class="table-item col col-lg-6" scope="row tbl-row">Address</th>
                                        <td class="table-item col col-lg-6">
                                            <span id="address-{{ $address->id }}">{{ $address->address }}</span>
                                            <button class="btn btn-sm btn-secondary" onclick="toggleEdit('address', {{ $address->id }})">✎</button>
                                            @if(count($user->addresses)>1)
                                            <button class="btn btn-sm btn-danger" onclick="removeAddress({{ $address->id }})">✖</button>
                                            @endif
                                            <form id="edit-address-form-{{ $address->id }}" action="{{ route('update.address', $address->id) }}" method="POST" style="display:none;">
                                                @csrf
                                                @method('PUT')
                                                <input type="text" name="address" value="{{ $address->address }}" required>
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </form>
                                            <form id="remove-address-form-{{ $address->id }}" action="{{ route('remove.address', $address->id) }}" method="POST" style="display:none;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <button class="btn btn-primary" onclick="addAddress()">Add New Address</button>
                            <form id="add-address-form" action="{{ route('add.address') }}" method="POST" style="display:none;">
                                @csrf
                                @method('PUT')
                                <input type="text" name="address" placeholder="New Address" required>
                                <button type="submit" class="btn btn-primary">Add</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>


        </div>
    </div>
</div>

<script>
  function toggleEdit(field, id = null) {
    if (id) {
      document.querySelector(`#edit-${field}-form-${id}`).style.display = 'block';
      document.querySelector(`#address-${id}`).style.display = 'none';
    } else {
      document.querySelectorAll(`#edit-${field}-form`).forEach(form => form.style.display = 'block');
      document.querySelectorAll(`#user-${field}`).forEach(span => span.style.display = 'none');
    }
  }

  function removeAddress(id) {
    if (confirm('Are you sure you want to delete this address?')) {
      document.querySelector(`#remove-address-form-${id}`).submit();
    }
  }

  function addAddress() {
    document.querySelector('#add-address-form').style.display = 'block';
  }
</script>
@endsection
