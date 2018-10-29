
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="gbk">
    <meta name="description" content="this" />
    <meta name="keywords" content="this" />
    <title>KM模板</title>
</head>
<body>
<style type="text/css">
    *{margin:0;padding:0;font-family:\5FAE\8F6F\96C5\9ED1;}
</style>


<div style="font-family:\5FAE\8F6F\96C5\9ED1;">
    <p style="padding:20px 13px;font-size:13px;color:#444;line-height:1.8;border-bottom:1px dashed #DEDCDC;font-family:\5FAE\8F6F\96C5\9ED1;"><strong>本期导读：</strong>{{ $special->desc }}</p>
    @foreach($articles as $article)
    <div>
        <div>
            <a href="{{ url('/article/'.$article->id) }}" title="{{$article->title}}" style="color:#161616;display:block;padding-bottom:10px;"  target="_blank">{{$article->title}}</a>
            <p style="color:#656060; font-size: 13px; margin:0;">{{ $article->summary }}</p>

            <p style="color:#8F8F8F;font-size:12px;margin:0;"><a style="color:#8F8F8F;" href="{!! $article->source_url !!}"  target="_blank"><strong>原文</strong>：{!! $article->source_url !!}</a></p>
        </div>
        <p style="display:block;margin-bottom:10px;border-bottom:1px dashed #DEDCDC;font-size:12px;color:#fff;margin-top:-5px;margin-bottom: 20px">------------------------------------------------------------</p>
    </div>
    @endforeach
</div>



</body>

</html>

