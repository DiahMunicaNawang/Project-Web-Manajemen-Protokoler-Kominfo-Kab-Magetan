<x-molecules.modal id="add-user-modal" title="Add User" type="add" formId="add-user-list-form" formMethod="POST"
    confirmButton="Konfirmasi" buttonId="add-button">

    <x-molecules.dropzone  label="Foto User (jpg,jpeg,png,webp)" id="User_image"
    name="photo" maxFiles="1" maxFilesSize="2" folderName="foto-User"
    acceptedFiles=".jpg,.jpeg,.png,.webp" />
    
    <x-molecules.input label="Nama User" name="name" type="text" placeholder="Enter user Username" required />
    <x-molecules.input label="NIP" name="nip" type="number" placeholder="0" required />

    <x-molecules.select id="gender" label="Gender" name="gender" required>
        <option value="L">Laki-laki</option>
        <option value="P">Perempuan</option>
    </x-molecules.select>

    <x-molecules.select id="role" label="Role" name="role" required>
        @foreach ($roles as $role)
            <option value="{{ $role->name }}">
                {{ $role->name }}
            </option>
        @endforeach
    </x-molecules.select>

    <x-molecules.input label="Email" name="email" type="email" placeholder="Email@gmail.com" required />
    <x-molecules.input label="Nomor Telepon" name="phone" type="number" placeholder="Nomor Telepon" />
    <x-molecules.input label="Password" name="password" type="password" placeholder="Enter user Password" required />
    <x-molecules.input label="Alamat" name="address" type="text" placeholder="Alamat User" required />
</x-molecules.modal>