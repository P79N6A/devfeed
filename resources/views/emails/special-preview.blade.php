
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="gbk">
    <meta name="description" content="this" />
    <meta name="keywords" content="this" />
    <title>邮件模板</title>
</head>
<body>
<style type="text/css">
    *{margin:0;padding:0;font-family:\5FAE\8F6F\96C5\9ED1;}
</style>
<TABLE class=main-table border=0 cellSpacing=0 cellPadding=0 width=800 align=center style="margin:0 auto">
    <TBODY>
    <TR>
        <TD style="BACKGROUND-COLOR: #fdfdfd">
            <div style="width:800px;margin:0 auto"><img src="http://ossweb-img.qq.com/images/tgideas/battery/img/head.jpg" style="margin:0 auto;padding:0;display:block;"></div>
            <p style="padding:20px 40px;font-size:13px;color:#444;line-height:1.8;border-bottom:1px dashed #DEDCDC;font-family:\5FAE\8F6F\96C5\9ED1;">
                <strong>本期导读：</strong>{{ $special->desc }}</p>
            <TABLE class=main-table border=0 cellSpacing=0 cellPadding=0 width=720 align=center style="margin:0 auto">
                <TBODY>
                <TR>
                    <TD>
                        <table width=100%>
                            @foreach($articles as $article)
                                <tr>
                                    <td align=left vertical-align=middle height="80" style="border-bottom:1px dashed #DEDCDC;" >
                                        <br>
                                        <a href="{{ url('/article/'.$article->id) }}" title="{{$article->title}}" style="color:#161616;display:block;padding-bottom:10px;" target="_blank">{{$article->title}}</a>

                                        <p style="color:#656060;font-size:13px;margin-bottom:10px;">{{ $article->summary }}</p>

                                        <p style="color:#8F8F8F;font-size:12px;margin-bottom:10px;"><a style="color:#8F8F8F;" href="{!! $article->source_url !!}" target="_blank"><strong>原文：</strong>{!! $article->source_url !!}</a></p>
                                        <br>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </TD>
                </TR>
                </TBODY>
            </TABLE>
            <div style="width:800px;margin:0 auto;margin-top:50px;">

                <img src="http://ossweb-img.qq.com/images/tgideas/battery/sign/miya.jpg" style="margin:0 auto;padding:0;display:block;">
            </div>
        </TD>

    </TR>
    <tr style="height:40px; ">
        <td><a href="http://km.oa.com/articles/show/240467" title="什么是前端充电站？" style="color:#8F8F8F;font-size:12px; ">什么是前端充电站？</a></td>
    </tr>
    </TBODY>
</TABLE>



<TABLE class=main-table border=0 cellSpacing=0 cellPadding=0 width=1000 align=center style="margin:0 auto">
    <TBODY>
    <TR>
        <TD style="BACKGROUND-COLOR: #fdfdfd">
            <div style="width:1000px;margin:0 auto"><img src="https://ossweb-img.qq.com/images/js/devfeed/ossweb-img/head2018.jpg" style="margin:0 auto;padding:0;display:block;"></div>
            <p style="padding:20px 40px;font-size:13px;color:#444;line-height:1.8;font-family:\5FAE\8F6F\96C5\9ED1;"></p>
            <TABLE class=main-table border=0 cellSpacing=0 cellPadding=0 width=920 align=center style="margin:0 auto;word-wrap: break-word; word-break: break-all;">
                <TBODY width=920 >
                <TR width=920 >
                    <td width=37 ><div style="width: 37px"><img src="https://ossweb-img.qq.com/images/js/devfeed/ossweb-img/intro.jpg" style="margin:0 auto;display:block;width:37px;height:70px"></div></td>
                    <td bgcolor="#F4F4F4" style="width:883px;height:70px"><div style="padding:10px 20px;font-size:13px;">
                            {{ $special->desc }}

                        </div></td>
                </TR>
                <TR>
                    <TD colspan="2">
                        <table width=100%>

                            @foreach($articles as $article)
                                <tr>
                                    <td align=left vertical-align=top height="80" style="border-bottom:1px dashed #DEDCDC;padding:20px 0" >
                                        <table>
                                            <tr>
                                                @if (empty($article->figure))

                                                    <td colspan="2">
                                                @else
                                                    <td vertical-align=top><img vertical-align=top src="{{ url('/article/'.$article->figure)}}" alt="{{$article->title}}" style="width:184px;padding-right: 20px "></td>
                                                    <td>
                                                @endif


                                                    <a href="{{ url('/article/'.$article->id) }}" title="{{$article->title}}" style="color:#161616;display:block;padding-bottom:10px;font-size:22px" target="_blank">{{$article->title}}</a>

                                                    <p style="color:#656060;font-size:13px;margin-bottom:10px;">{{ $article->summary }}</p>

                                                    <p style="color:#8F8F8F;font-size:12px;margin-bottom:10px;"><a style="color:#8F8F8F;" href="{!! $article->source_url !!}" target="_blank"><strong>原文：</strong>{!! $article->source_url !!}</a></p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            @endforeach



                        </table>
                    </TD>
                </TR>
                </TBODY>
            </TABLE>
            <div style="width:1000px;margin:0 auto;margin-top:50px;">

                <img src="https://ossweb-img.qq.com/images/js/devfeed/ossweb-img/ft2018.jpg" style="margin:0 auto;padding:0;display:block;">
            </div>
        </TD>

    </TR>
    <tr style="height:40px; ">
        <td><a href="http://km.oa.com/articles/show/240467" title="什么是前端充电站？" style="color:#8F8F8F;font-size:12px; ">什么是前端充电站？</a></td>
    </tr>
    </TBODY>
</TABLE>




</body>

</html>

