@asset("css/foo.css","css/bar.css", output="css/out1.css")
cesar
@style("css/foo.css","css/bar.css", output="css/out.css")
     <link href="{{ $asset_url }}" type="text/css" rel="stylesheet" />
@end
     <link href="{{ css/out1.css }}" type="text/css" rel="stylesheet" />
rodas
