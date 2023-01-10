<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>DB</h1> 
    @foreach($data as $item)
    <p>{{ $item->name }}</p>
    <p>{{ $item->start }}</p>
    <p>{{ $item->end }}</p>
    @endforeach


    <h2>걸리는 시간(분)</h2>
    @foreach($term as $item)
    <p>{{ $item }}</p>
    @endforeach
    <script>
      //let data = "{{ $data }}";
      //console.log(data);
    </script>
</body>
</html>
