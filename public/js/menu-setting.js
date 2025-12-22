"use strict";
document.addEventListener("DOMContentLoaded", function () {
    // =========================================================
    // =========    Menu Customizer [ HTML ] code   ============
    // =========================================================
    // ==================    Menu Customizer Start   ===========
    // =========================================================
    // open Menu Styler
    var pctoggle = document.querySelector("#styleSelector > .style-toggler");
    if (pctoggle) {
        pctoggle.addEventListener('click', function () {
            if (!document.querySelector("#styleSelector").classList.contains('open')) {
                document.querySelector("#styleSelector").classList.add("open");
            } else {
                document.querySelector("#styleSelector").classList.remove("open");
            }
        });
    }

    // layout types
    var layouttype = document.querySelectorAll(".layout-type > a");
    for (var h = 0; h < layouttype.length; h++) {
        var c = layouttype[h];
        c.addEventListener('click', function (event) {
            document.querySelector(".layout-type > a.active").classList.remove("active");
            var targetElement = event.target;
            if (targetElement.tagName == "SPAN") {
                targetElement = targetElement.parentNode;
            }
            targetElement.classList.add("active");
            var temp = targetElement.getAttribute('data-value');
            document.querySelector('head').insertAdjacentHTML("beforeend", '<link rel="stylesheet" class="layout-css" href="">');
            if (temp == "menu-dark") {
                removeClassByPrefix(document.querySelector(".pcoded-navbar"), 'menu-');
                document.querySelector(".pcoded-navbar").classList.remove("navbar-dark");
            }
            if (temp == "menu-light") {
                removeClassByPrefix(document.querySelector(".pcoded-navbar"), 'menu-');
                document.querySelector(".pcoded-navbar").classList.remove("navbar-dark");
                document.querySelector(".pcoded-navbar").classList.add(temp);
            }
            if (temp == "reset") {
                location.reload();
            }
            if (temp == "dark") {
                removeClassByPrefix(document.querySelector(".pcoded-navbar"), 'menu-');
                document.querySelector(".pcoded-navbar").classList.remove("navbar-dark");
                document.querySelector(".layout-css").setAttribute('href', '../assets/css/layout-dark.css');
            } else {
                document.querySelector(".layout-css").setAttribute('href', '');
            }
        });
    }
    // Header Color
    var headercolor = document.querySelectorAll(".header-color > a");
    for (var h = 0; h < headercolor.length; h++) {
        var c = headercolor[h];
        c.addEventListener('click', function (event) {
            document.querySelector(".header-color > a.active").classList.remove("active");
            var targetElement = event.target;
            if (targetElement.tagName == "SPAN") {
                targetElement = targetElement.parentNode;
            }
            targetElement.classList.add("active");
            var temp = targetElement.getAttribute('data-value');
            if (temp == "header-default") {
                removeClassByPrefix(document.querySelector(".pcoded-header"), 'header-');
            } else {
                removeClassByPrefix(document.querySelector(".pcoded-header"), 'header-');
                document.querySelector(".pcoded-header").classList.add(temp);
            }
        });
    }
    // rtl layouts
    var rtllayout = document.querySelector("#theme-rtl");
    if (rtllayout) {
        rtllayout.addEventListener('click', function () {
            document.querySelector('head').insertAdjacentHTML("beforeend", '<link rel="stylesheet" class="rtl-css" href="">');
            if (rtllayout.checked) {
                document.querySelector(".rtl-css").setAttribute('href', '../assets/css/layout-rtl.css');
            } else {
                document.querySelector(".rtl-css").setAttribute('href', '');
            }
        });
    }
    // Menu Fixed
    var menufix = document.querySelector("#menu-fixed");
    if (menufix) {
        menufix.addEventListener('click', function () {
            if (menufix.checked) {
                document.querySelector(".pcoded-navbar").classList.add("menupos-fixed");
            } else {
                document.querySelector(".pcoded-navbar").classList.remove("menupos-fixed");
            }
        });
    }
    // Header Fixed
    var headerfix = document.querySelector("#header-fixed");
    if (headerfix) {
        headerfix.addEventListener('click', function () {
            if (headerfix.checked) {
                document.querySelector(".pcoded-header").classList.add("headerpos-fixed");
            } else {
                document.querySelector(".pcoded-header").classList.remove("headerpos-fixed");
            }
        });
    }
    // breadcumb sicky
    var brdlayout = document.querySelector("#breadcumb-layouts");
    if (brdlayout) {
        brdlayout.addEventListener('click', function () {
            if (brdlayout.checked) {
                document.querySelector(".page-header").classList.add("breadcumb-sticky");
            } else {
                document.querySelector(".page-header").classList.remove("breadcumb-sticky");
            }
        });
    }
    // Box layouts
    var boxlayout = document.querySelector("#box-layouts");
    if (boxlayout) {
        boxlayout.addEventListener('click', function () {
            if (boxlayout.checked) {
                document.querySelector("body").classList.add("container");
                document.querySelector("body").classList.add("box-layout");
            } else {
                document.querySelector("body").classList.remove("container");
                document.querySelector("body").classList.remove("box-layout");
            }
        });
    }
    function removeClassByPrefix(node, prefix) {
        for (let i = 0; i < node.classList.length; i++) {
            let value = node.classList[i];
            if (value.startsWith(prefix)) {
                node.classList.remove(value);
            }
        }
    }
    // ==================    Menu Customizer End   =============
    // =========================================================
});