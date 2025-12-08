<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Form Not Found</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f7fa;
            color: #333;
        }

        .not-found-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 2rem;
        }

        .not-found-card {
            background-color: #fff;
            padding: 3rem 2rem;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            text-align: center;
            max-width: 460px;
            width: 100%;
        }

        .not-found-card img {
            max-width: 100px;
            margin-bottom: 1.5rem;
        }

        .not-found-card h1 {
            color: #dc3545;
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .not-found-card p {
            font-size: 1.1rem;
            color: #555;
            margin-bottom: 2rem;
        }

        .not-found-card a.btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background-color: #007bff;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: background 0.2s ease;
        }

        .not-found-card a.btn:hover {
            background-color: #0056b3;
        }

        .not-found-card i {
            margin-right: 0.5rem;
        }
    </style>
</head>
<body>

<div class="not-found-wrapper">
    <div class="not-found-card">
        <img src="https://cdn-icons-png.flaticon.com/512/6134/6134065.png" alt="Form Not Found">
        <h1><i class="fa fa-exclamation-triangle"></i> Form Not Found</h1>
        <p>The form you're trying to access does not exist or has been deleted by its owner.</p>
        <a href="/" class="btn"><i class="fa fa-arrow-left"></i> Back to Home</a>
    </div>
</div>

</body>
</html>
