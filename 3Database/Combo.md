# Combo trazendo do controller
```php
<div class="form-group {{ $errors->has('role') ? 'has-error' : ''}}">
    <label for="password" class="control-label">{{ 'Role' }}</label>
        <select class="form-control select2" style="width: 100%;" id="role" name="slug">
             <option>Select Role</option>
             @foreach($users as $user)
                 <option value="{{$user->id}}">{{$user->slug}}</option>
             @endforeach
       </select>
</div>
```

