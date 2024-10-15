<x-molecules.modal id="edit-user-modal" title="Edit User" type="edit" formId="edit-user-list-form" formMethod="POST"
    confirmButton="Konfirmasi" buttonId="edit-button">

    <x-molecules.dropzone label="Foto User (jpg,jpeg,png,webp)" id="edit_User_image"
    name="photo" maxFiles="1" maxFilesSize="2" folderName="foto-User"
    acceptedFiles=".jpg,.jpeg,.png,.webp" />
    
    <x-molecules.input label="Username" id="edit_name" name="name" type="text" placeholder="Enter user Username" required />
    <x-molecules.input label="NIP" id="edit_nip" name="nip" type="number" placeholder="0" required />

    <x-molecules.select id="edit_gender" label="Gender" name="gender" required>
        <option value="L">Laki-laki</option>
        <option value="P">Perempuan</option>
    </x-molecules.select>

    <x-molecules.select id="edit-role" label="Role" name="role" required>
        @foreach ($roles as $role)
            <option value="{{ $role->name }}">
                {{ $role->name }}
            </option>
        @endforeach
    </x-molecules.select>

    <x-molecules.input label="Email" id="edit_email" name="email" type="email" placeholder="Email@gmail.com" required />
    <x-molecules.input label="Nomor Telepon" id="edit_phone" name="phone" type="number" placeholder="Nomor Telepon" />
    <x-molecules.input label="Password" id="edit_password" name="password" type="password" placeholder="Enter user Password" required />
    <x-molecules.input label="Alamat" id="edit_address" name="address" type="text" placeholder="Alamat User" required/>
</x-molecules.modal>