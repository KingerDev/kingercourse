<h2>{{ $course->title  }}</h2>
<h2>{{ $course->tagline  }}</h2>
<p>{{ $course->description  }}</p>
<p>{{ $course->videos_count }} videos</p>

<ul>
    @foreach($course->learnings as $learning)
        <li>{{ $learning }}</li>
    @endforeach
</ul>

<img src="{{ asset("images/$course->image_name") }}" alt="Image of the course {{ $course->title }}">
<a href="#" class="paddle_button" data-theme='light'
   data-items='[
    {
      "priceId": "pri_01hjxx24wbgaqkjk4ma50erd67",
      "quantity": 1
    }
  ]'
>Buy Now!
</a>

<script src="https://cdn.paddle.com/paddle/v2/paddle.js"></script>
<script type="text/javascript">
    @env('local')
    Paddle.Environment.set('sandbox');
    @endenv

    Paddle.Setup({
        token: 'test_23348379bdc0f092984271288f7',
        pwAuth: '253273616fa68d2c93542398267b0af660b6c474502e1a6742',
    });
</script>