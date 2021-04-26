<html>
    <header>
        <title>Aviso Capela</title>
        <meta http-equiv="Content-Language" content="th" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="shortcut icon" type="image/ico" href="{{ asset('img/favicon.ico') }}">

        <style>
            body {
                font-size: 30px;
            }
            p {
                margin-bottom: 10px;
            }
        </style>
    </header>

    <body>
        <div>
            <p style="text-align:center;"><img src= "{{ asset('img/logo3.png') }}" style="width: 140px; margin-bottom:60px;"></p>
            <p>Falecido: <strong>{{ $regSepultamento['falecido'] }}</strong></p>
            <p>Data Sepultamento:&nbsp;&nbsp;<strong>{{ $regSepultamento['data'] }}</strong>&nbsp;&nbsp;&nbsp;Hora: <strong>{{ $regSepultamento['hora'] }}</strong></p>
            <p><span>Funeraria: </span><span> {{ $regSepultamento['funeraria'] }}</span></p>
            <p>Cemitério: São Francisco de Paula - Catumbi</p>
        </div>
    </body>

</html>
