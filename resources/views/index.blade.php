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

    <script>
      var data = "{{ $data }}";
      let orders = "{{ $orders }}"
      console.log(orders.replace(/&quot;/g, '"'));
      console.log(orders);
    </script>
</body>
</html>
