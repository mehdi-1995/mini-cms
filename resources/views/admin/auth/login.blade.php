<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>ورود ادمین</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card p-4 shadow">
                    <h4 class="mb-3 text-center">ورود ادمین</h4>

                    <form method="POST" action="{{ route('admin.login') }}">
                        @csrf
                        <div class="mb-3">
                            <input type="email" name="email" class="form-control" placeholder="ایمیل">
                        </div>
                        <div class="mb-3">
                            <input type="password" name="password" class="form-control" placeholder="رمز عبور">
                        </div>
                        <button class="btn btn-dark w-100">ورود</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
