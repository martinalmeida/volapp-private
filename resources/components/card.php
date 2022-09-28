<!DOCTYPE html>
<!-- 
Template Name:  SmartAdmin Responsive WebApp - Template build with Twitter Bootstrap 4
Version: 4.5.1
Author: Sunnyat A.
Website: http://gootbootstrap.com
Purchase: https://wrapbootstrap.com/theme/smartadmin-responsive-webapp-WB0573SK0?ref=myorange
License: You must have a valid license purchased only from wrapbootstrap.com (link above) in order to legally use this theme for your project.
-->

<html lang="en">

<head>
    <meta charset="utf-8">
    <title>
        Cards 
    </title>
    <meta name="description" content="Cards">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
    <!-- Call App Mode on ios devices -->
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no">
    <!-- base css -->
    <link id="vendorsbundle" rel="stylesheet" media="screen, print" href="css/vendors.bundle.css">
    <link id="appbundle" rel="stylesheet" media="screen, print" href="css/app.bundle.css">
    <link id="mytheme" rel="stylesheet" media="screen, print" href="#">
    <link id="myskin" rel="stylesheet" media="screen, print" href="css/skins/skin-master.css">
    <!-- Place favicon.ico in the root directory -->
    <link rel="apple-touch-icon" sizes="180x180" href="img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon/favicon-32x32.png">
    <link rel="mask-icon" href="img/favicon/safari-pinned-tab.svg" color="#5bbad5">
</head>

<body class="mod-bg-1 mod-nav-link ">
    <!-- DOC: script to save and load page settings -->
    <script>
        /**
         *	This script should be placed right after the body tag for fast execution 
         *	Note: the script is written in pure javascript and does not depend on thirdparty library
         **/
        'use strict';

        var classHolder = document.getElementsByTagName("BODY")[0],
            /** 
             * Load from localstorage
             **/
            themeSettings = (localStorage.getItem('themeSettings')) ? JSON.parse(localStorage.getItem('themeSettings')) : {},
            themeURL = themeSettings.themeURL || '',
            themeOptions = themeSettings.themeOptions || '';
        /** 
         * Load theme options
         **/
        if (themeSettings.themeOptions) {
            classHolder.className = themeSettings.themeOptions;
            console.log("%c✔ Theme settings loaded", "color: #148f32");
        } else {
            console.log("%c✔ Heads up! Theme settings is empty or does not exist, loading default settings...", "color: #ed1c24");
        }
        if (themeSettings.themeURL && !document.getElementById('mytheme')) {
            var cssfile = document.createElement('link');
            cssfile.id = 'mytheme';
            cssfile.rel = 'stylesheet';
            cssfile.href = themeURL;
            document.getElementsByTagName('head')[0].appendChild(cssfile);

        } else if (themeSettings.themeURL && document.getElementById('mytheme')) {
            document.getElementById('mytheme').href = themeSettings.themeURL;
        }
        /** 
         * Save to localstorage 
         **/
        var saveSettings = function() {
            themeSettings.themeOptions = String(classHolder.className).split(/[^\w-]+/).filter(function(item) {
                return /^(nav|header|footer|mod|display)-/i.test(item);
            }).join(' ');
            if (document.getElementById('mytheme')) {
                themeSettings.themeURL = document.getElementById('mytheme').getAttribute("href");
            };
            localStorage.setItem('themeSettings', JSON.stringify(themeSettings));
        }
        /** 
         * Reset settings
         **/
        var resetSettings = function() {
            localStorage.setItem("themeSettings", "");
        }
    </script>

    <!-- Card group -->
    <div id="panel-10" class="panel">
        <div class="panel-hdr">
            <h2>
                Card <span class="fw-300"></span>
            </h2>
            <div class="panel-toolbar">
                <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
            </div>
        </div>
        <div class="panel-container show">
            <div class="panel-content">
                <div class="panel-tag">
                </div>
                <div class="card-group">
                    <div class="card">
                        <div class="w-100 bg-fusion-50 rounded-top border-top-right-radius-0" style="padding:40px 0 40px;"></div>
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p>
                            <small class="text-muted">Last updated 3 mins ago</small>
                        </div>
                    </div>
                    <div class="card">
                        <div class="w-100 bg-fusion-50" style="padding:40px 0 40px;"></div>
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p>
                            <small class="text-muted">Last updated 3 mins ago</small>
                        </div>
                    </div>
                    <div class="card">
                        <div class="w-100 bg-fusion-50 rounded-top border-top-left-radius-0 " style="padding:40px 0 40px;"></div>
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p>
                            <small class="text-muted">Last updated 3 mins ago</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>

    <script src="js/vendors.bundle.js"></script>
    <script src="js/app.bundle.js"></script>
    <script>
        /* infinite nav pills */
        $('#js-nav-pills-menu').menuSlider({
            element: $('#js-nav-pills-menu'),
            wrapperId: 'test-nav'
        });


        var ng_bgColors,
            ng_bgColors_URL = "media/data/ng-bg-colors.json",
            formatBgColors = [];

        $.when(
            $.getJSON(ng_bgColors_URL, function(data) {
                ng_bgColors = data;
            })
        ).then(function() {
            if (ng_bgColors) {

                formatBgColors.push($('<option></option>').attr("value", null).text("select background"));

                //formatTextColors
                jQuery.each(ng_bgColors, function(index, item) {
                    formatBgColors.push($('<option></option>').attr("value", item).addClass(item).text(item))
                });

                $("select.js-bg-color").empty().append(formatBgColors);

            } else {
                console.log("somethign went wrong!")
            }
        });

        /* change background */
        $(document).on('change', '.js-bg-color', function() {
            var setBgColor = $('select.js-bg-color').val();
            var setValue = $('select.js-bg-target').val();

            $('select.js-bg-color').removeClassPrefix('bg-').addClass(setBgColor);
            $(setValue).removeClassPrefix('bg-').addClass(setBgColor);
        })

        /* change border */
        $(document).on('change', '.js-border-color', function() {
            var setBorderColor = $('select.js-border-color').val();
            $("#cp-2").removeClassPrefix('border-').addClass(setBorderColor);
            $('select.js-border-color').removeClassPrefix('border-').addClass(setBorderColor);
        })

        /* change target */
        $(document).on('change', '.js-bg-target', function() {
            //reset color selection
            $('select.js-bg-color').prop('selectedIndex', 0).removeClassPrefix('bg-');
        })
    </script>
</body>
<!-- END Body -->

</html>