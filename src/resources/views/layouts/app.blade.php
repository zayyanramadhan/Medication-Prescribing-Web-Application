<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>User Data</title>
    <style>
        .wrapper {
            display: flex;
            width: 100%;
            height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: #343a40;
            color: white;
            padding: 15px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
        }

        .sidebar .nav-link {
            color: white;
            margin-bottom: 10px;
        }

        .sidebar .nav-link:hover {
            background-color: #495057;
            border-radius: 5px;
        }

        .sidebar .nav-link i {
            margin-right: 10px;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px);
            overflow-x: auto;
            height: 100%;
        }
    </style>

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">User Data</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>

    <div class="wrapper">
        <div class="sidebar">
            <h5 class="text-center">Menu</h5>
            <ul class="nav flex-column">
                @if(auth()->user()->level == "admin")
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('userdata.index') }}">
                        <i class="fas fa-users"></i> User Data
                    </a>
                </li>
                @endif
                @if(auth()->user()->level == "admin" || auth()->user()->level == "dokter")
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pemeriksaan.index') }}">
                        <i class="fa fa-stethoscope"></i> Pemeriksaan
                    </a>
                </li>
                @endif
                @if(auth()->user()->level == "admin" || auth()->user()->level == "dokter" || auth()->user()->level == "apoteker")
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('resep.index') }}">
                        <i class="fa fa-medkit"></i> Resep
                    </a>
                </li>
                @endif
                <li class="nav-item">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="nav-link" style="background: none; border: none; color: white;">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
                </li>
            </ul>
        </div>

        <div class="content">
            <div class="container mt-4">
                @yield('content')
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
