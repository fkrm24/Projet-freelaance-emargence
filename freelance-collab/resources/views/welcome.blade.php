<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Emargence - suivi des partenaires</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center" style="background: url('{{ asset('images/fondecran.png') }}') no-repeat center center fixed; background-size: cover;">
    <div class="bg-white rounded-2xl shadow-2xl p-50 flex flex-col items-center justify-center max-w-md h-96 md:h-[32rem] py-20 border border-[#152C54]" style="height: 500px; width: 500px;">
        <h1 class="text-3xl md:text-5xl font-extrabold text-[#152C54] mb-8 tracking-tight text-center"> <span class='text-[#2748E9]'>Emargence</span> <span class="text-[#152C54]">- suivi des partenaires</span></h1>
        <p class="text-base md:text-lg text-[#000000] mb-8 text-center ">Optimisez la collaboration entre freelances et entreprises avec une plateforme moderne et intuitive.</p>
        <div class="flex gap-4 w-full justify-center mt-16">
            <a href="{{ route('login') }}" class="px-8 py-5 rounded-lg font-semibold bg-[#2748E9] text-white hover:bg-[#018FFD] shadow transition">Connexion</a>
            <a href="{{ route('register') }}" class="px-8 py-5 rounded-lg font-semibold bg-[#FF7E00] text-white hover:bg-[#018FFD] shadow transition">Inscription</a>
        </div>
    </div>
</body>
</html>
