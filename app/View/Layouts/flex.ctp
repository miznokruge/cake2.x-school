<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--saved from url = (0014)about:internet -->
<html xmlns = "http://www.w3.org/1999/xhtml" lang = "en" xml:lang = "en">
    <head>
        <title>lala</title>
        <meta http-equiv = "Content-Type" content = "text/html; charset=utf-8" />
        <style type = "text/css" media = "screen">
            html, body { height:100%;
            }
            body { margin:0;
                   padding:0;
                   overflow:auto;
            }
            #flashContent { display:none; margin:auto; }
        </style>
        <script type="text/javascript" src="/js/jquery.js"></script>
        <script type = "text/javascript" src = "/js/swfobject/swfobject.js"></script>
        <script type="text/javascript" src="/js/flexpaper_flash.js"></script>
        <script type="text/javascript">
            < !-- For  version detection, set to min.required Flash Player version, or 0 (or 0.0.0), for no version detection.-- >
                    var swfVersionStr = "10.0.0";
                    < !-- To use express install, set to playerProductInstall.swf, otherwise the empty string.-- >
                    var xiSwfUrlStr = "";
            var flashvars = {
                SwfFile: escape("<?php echo $this->webroot; ?>files/swf/<?php echo $content_for_layout; ?>.swf"),
                Scale: 1.0,
                ZoomTransition: "easeOut",
                ZoomTime: 0.5,
                ZoomInterval: 0.1,
                FitPageOnLoad: false,
                FitWidthOnLoad: true,
                PrintEnabled: true,
                FullScreenAsMaxWindow: true,
                ProgressiveLoading: true,
                PrintToolsVisible: true,
                ViewModeToolsVisible: true,
                ZoomToolsVisible: true,
                FullScreenVisible: true,
                NavToolsVisible: true,
                CursorToolsVisible: true,
                SearchToolsVisible: true,
                localeChain: "en_US"
            };
            var params = {
            }
            params.quality = "high";
            params.bgcolor = "#ffffff";
            params.allowscriptaccess = "sameDomain";
            params.allowfullscreen = "true";
            var attributes = {};
            attributes.id = "FlexPaperViewer";
            attributes.name = "FlexPaperViewer";
            swfobject.embedSWF(
                    "<?php echo $this->webroot ?>FlexPaperViewer.swf", "flashContent",
                    "800", "600",
                    swfVersionStr, xiSwfUrlStr, flashvars, params, attributes);
            swfobject.createCSS("#flashContent", "display:block;text-align:left;");
        </script>
    </head>
    <body>
        <div style="position:absolute;left:10px;top:10px;">
            <div id="flashContent">
                <p>
                    To view this page ensure that Adobe Flash Player version
                    10.0.0 or greater is installed.
                </p>
                <script type="text/javascript">
                    var pageHost = ((document.location.protocol == "https:") ? "https://" : "http://");
                    document.write("<a href='http://www.adobe.com/go/getflashplayer'><img src='"
                            + pageHost + "www.adobe.com/images/shared/download_buttons/get_flash_player.gif' alt='Get Adobe Flash player' /></a>");
                </script>
            </div>
        </div>
    </body>
</html>