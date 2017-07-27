<div class="footer-v1">
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 md-margin-bottom-40">
                    <div class="headline">
                        <h2>ABOUT US</h2>
                    </div>
                    <a href="<?php echo BASE_URL; ?>" class="img_href">
                        <img src="<?php echo BASE_URL; ?>/assets/img/ibm_watson_partner.png"
                             alt="IBM Watson Ecosystem Partner logo">
                        <p class="symb">
                            GoFetchCode is a partnership of IBM Watson and ENGEO, a leading provider of geotechnical,
                            environmental, and hydrological engineering.
                        </p>
                        <p>Official ICC Building Codes are a feature of GoFetchCode.</p>
                </div>

                <div class="col-md-4 md-margin-bottom-40">
                    <div class="posts">
                        <div class="headline">
                            <h2>LATEST POSTS</h2>
                        </div>
                        <ul class="list-unstyled latest-list">
                            <li>
                                <a href="https://www.gofetchcode.com/oshas-top-10-violations-construction-industry/">OSHA’s
                                    Top 10 Most Cited Violations for the Construction Industry</a>
                                <span class="post-date">July 20, 2017</span>
                            </li>
                            <li>
                                <a href="https://www.gofetchcode.com/international-building-code-2015/">The
                                    International Building Code (2015)</a>
                                <span class="post-date">July 7, 2017</span>
                            </li>
                            <li>
                                <a href="https://www.gofetchcode.com/safe-and-effective-subcontractor-management/">Safe
                                    and Effective Subcontractor Management</a>
                                <span class="post-date">June 20, 2017</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-4 map-img md-margin-bottom-40">
                    <div class="headline">
                        <h2>LINKS & CONTACT</h2>
                    </div>
                    <div class="textwidget">
                        <p>
                            <a style="color: #a2a2a2;" href="https://www.gofetchcode.com/about-us" target="_blank"
                               rel="noopener">ABOUT US</a><br>
                            <a style="color: #a2a2a2;" href="http://www.ibm.com/watson/" target="_blank" rel="noopener">IBM
                                WATSON</a><br>
                            <a style="color: #a2a2a2;" href="http://www.engeo.com/" target="_blank" rel="noopener">ENGEO
                                INC</a>
                        </p>
                        <address class="md-margin-bottom-40" style="margin-top: 10px;">Address: 2010 Crow Canyon Place,
                            Suite 250 San Ramon, CA 94583-4634<br>
                            T: (925) 866-9000<br>
                            <a style="margin-left: -8px;" href="mailto:marketing@gofetchcode.com" target="_top"><img
                                    style="width: 180px; margin-top: 10px;"
                                    src="<?php echo BASE_URL; ?>/assets/img/info.png"></a>
                        </address>

                        <ul class="footer-socials" style="text-align: left">
                            <li class="social-icon">
                                <a class="" rel="nofollow" title="Twitter"
                                   aria-label="Twitter" href="http://twitter.com/gofetchcode"
                                   target="_blank">
                                    <i class="fa fa-twitter"></i>
                                </a>
                            </li>
                            <li class="social-icon">
                                <a class="" rel="nofollow" title="LinkedIn"
                                   aria-label="LinkedIn"
                                   href="https://www.linkedin.com/company/gofetchcode"
                                   target="_blank">
                                    <i class="fa fa-linkedin"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="copyright">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <p>
                        2017 &copy; All Rights Reserved.
                        <a href="<?php echo BASE_URL . 'privacypolicy.php'; ?>">Privacy Policy</a> | <a
                            href="<?php echo BASE_URL . 'termsofservice.php'; ?>">Terms of Service</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!--     Start of gofetchcode Zendesk Widget script-->
    <script>/*<![CDATA[*/
        window.zEmbed || function (e, t) {
            var n, o, d, i, s, a = [], r = document.createElement("iframe");
            window.zEmbed = function () {
                a.push(arguments)
            }, window.zE = window.zE || window.zEmbed, r.src = "javascript:false", r.title = "", r.role = "presentation", (r.frameElement || r).style.cssText = "display: none", d = document.getElementsByTagName("script"), d = d[d.length - 1], d.parentNode.insertBefore(r, d), i = r.contentWindow, s = i.document;
            try {
                o = s
            } catch (e) {
                n = document.domain, r.src = 'javascript:var d=document.open();d.domain="' + n + '";void(0);', o = s
            }
            o.open()._l = function () {
                var o = this.createElement("script");
                n && (this.domain = n), o.id = "js-iframe-async", o.src = e, this.t = +new Date, this.zendeskHost = t, this.zEQueue = a, this.body.appendChild(o)
            }, o.write('<body onload="document._l();">'), o.close()
        }("https://assets.zendesk.com/embeddable_framework/main.js", "gofetchcode.zendesk.com");
        /*]]>*/</script>
    <script type="text/javascript">
        (function (e, t) {
            var n = e.amplitude || {_q: [], _iq: {}};
            var r = t.createElement("script");
            r.type = "text/javascript";
            r.async = true;
            r.src = "https://d24n15hnbwhuhn.cloudfront.net/libs/amplitude-3.4.0-min.gz.js";
            r.onload = function () {
                e.amplitude.runQueuedFunctions()
            };
            var i = t.getElementsByTagName("script")[0];
            i.parentNode.insertBefore(r, i);
            function s(e, t) {
                e.prototype[t] = function () {
                    this._q.push([t].concat(Array.prototype.slice.call(arguments, 0)));
                    return this
                }
            }

            var o = function () {
                this._q = [];
                return this
            };
            var a = ["add", "append", "clearAll", "prepend", "set", "setOnce", "unset"];
            for (var u = 0; u < a.length; u++) {
                s(o, a[u])
            }
            n.Identify = o;
            var c = function () {
                this._q = [];
                return this;
            };
            var p = ["setProductId", "setQuantity", "setPrice", "setRevenueType", "setEventProperties"];
            for (var l = 0; l < p.length; l++) {
                s(c, p[l])
            }
            n.Revenue = c;
            var d = ["init", "logEvent", "logRevenue", "setUserId", "setUserProperties", "setOptOut", "setVersionName", "setDomain", "setDeviceId", "setGlobalUserProperties", "identify", "clearUserProperties", "setGroup", "logRevenueV2", "regenerateDeviceId", "logEventWithTimestamp", "logEventWithGroups"];

            function v(e) {
                function t(t) {
                    e[t] = function () {
                        e._q.push([t].concat(Array.prototype.slice.call(arguments, 0)));
                    }
                }

                for (var n = 0; n < d.length; n++) {
                    t(d[n])
                }
            }

            v(n);
            n.getInstance = function (e) {
                e = (!e || e.length === 0 ? "$default_instance" : e).toLowerCase();
                if (!n._iq.hasOwnProperty(e)) {
                    n._iq[e] = {_q: []};
                    v(n._iq[e])
                }
                return n._iq[e]
            };
            e.amplitude = n;
        })(window, document);

        amplitude.getInstance().init("35ef859515f2582d1ca664525ee737dc");
    </script>
    <!--    <div style="display:none;">-->
    <!--        <img height="1" width="1" style="border-style:none;" alt=""-->
    <!--             src="//www.googleadservices.com/pagead/conversion/865029976/?label=vkiNCJrvpHAQ2J69nAM&amp;guid=ON&amp;script=0"/>-->
    <!--    </div>-->
    </noscript>

    <!-- Google Code for Website Lead from Adwords Conversion Page -->
    <script type="text/javascript">
        /* <![CDATA[ */
        var google_conversion_id = 865029976;
        var google_conversion_language = "en";
        var google_conversion_format = "3";
        var google_conversion_color = "ffffff";
        var google_conversion_label = "vkiNCJrvpHAQ2J69nAM";
        var google_remarketing_only = false;
        /* ]]> */
    </script>
    <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
    </script>
    <noscript>
        <div style="display:inline;">
            <img height="1" width="1" style="border-style:none;" alt=""
                 src="//www.googleadservices.com/pagead/conversion/865029976/?label=vkiNCJrvpHAQ2J69nAM&amp;guid=ON&amp;script=0"/>
        </div>
    </noscript>

    <!-- End of gofetchcode Zendesk Widget script -->

</div>
</div>
</body>
</html>