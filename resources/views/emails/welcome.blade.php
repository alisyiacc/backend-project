<!DOCTYPE html>
<html lang="id">
<body style="font-family: Arial, sans-serif; background:#eef5fc; padding:24px;">
  <div style="max-width:520px; margin:auto; background:#fff; border-radius:16px; padding:28px;">
    <h2 style="color:#2b6cd4; margin-top:0;">Halo, {{ $user->name }}! 👋</h2>
    <p>Pendaftaran akun <strong>MountClimb</strong> kamu berhasil.</p>
    <p>Akun kamu terdaftar dengan email: <strong>{{ $user->email }}</strong></p>
    <p>Sekarang kamu bisa masuk ke aplikasi dan mulai memesan tiket pendakian.</p>
    <p style="color:#6b7a8c; font-size:13px;">Kalau kamu tidak merasa mendaftar, abaikan email ini.</p>
    <p>Salam,<br>Tim MountClimb</p>
  </div>
</body>
</html>
