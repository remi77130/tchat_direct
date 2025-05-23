window.addEventListener("focus", function() {
    reloader()
});
var isextensionenabled = !0
  , activeTab = function() {
    var e, t, n = {
        hidden: "visibilitychange",
        webkitHidden: "webkitvisibilitychange"
    };
    for (e in n)
        if (e in document) {
            t = n[e];
            break
        }
    return function(n) {
        return n && document.addEventListener(t, n),
        !document[e]
    }
}();
function reloader() {
    if (isextensionenabled) {
        var e = $("body").html()
          , t = $("body a");
        function n(e) {
            return mcUtils.extractEmails(e)
        }
        function o(e) {
            return mcUtils.extractLinks(e)
        }
        function i(e) {
            var t = [];
            return $.each(e, function(e, n) {
                -1 == $.inArray(n, t) && t.push(n)
            }),
            t
        }
        function s(e) {
            var t = "";
            for (var n in e)
                t += e[n] + "<br>";
            return t
        }
        if (null == n(e))
            chrome.runtime.sendMessage({
                from: "content",
                subject: "sendMailCount",
                mailCount: 0
            }),
            chrome.runtime.sendMessage({
                from: "content",
                subject: "sendEmails",
                mails: "None Found",
                mailsFound: "0"
            });
        else
            try {
                chrome.runtime.sendMessage({
                    from: "content",
                    subject: "sendMailCount",
                    mailCount: i(n(e)).length
                }),
                chrome.runtime.sendMessage({
                    from: "content",
                    subject: "sendEmails",
                    mails: s(i(n(e))),
                    mailsFound: i(n(e)).length,
                    url: window.location.href
                }),
                chrome.runtime.sendMessage({
                    options: "saveautosave",
                    mails: i(n(e)),
                    url: window.location.href
                })
            } catch (e) {
                console.log("Refresh the page to reload the Email Extractor Chrome extension.")
            }
        if (null == o(t))
            chrome.runtime.sendMessage({
                from: "content",
                subject: "sendLinks",
                links: []
            });
        else
            try {
                chrome.runtime.sendMessage({
                    from: "content",
                    subject: "sendLinks",
                    links: s(o(t))
                })
            } catch (e) {
                console.log("Refresh the page to reload the Email Extractor Chrome extension.")
            }
    }
}
var timeout = null;
async function copyToTheClipboard(e, t) {
    var n = e
      , o = document.createElement("textarea");
    document.body.appendChild(o),
    n = n.replace(/<br\s*\/?>/gm, "\r\n"),
    o.value = n,
    o.focus(),
    o.select();
    var i = document.createElement("div");
    i.style.display = "none",
    i.style.textAlign = "center",
    i.id = "emailExtractorAlert",
    i.style.backgroundColor = "#ffffff",
    i.style.color = "#000000",
    i.style.position = "fixed",
    i.style.right = "5px",
    i.style.top = "5px",
    i.style.width = "300px",
    i.style.zIndex = "99999",
    i.style.border = "1px solid #000000",
    i.style.borderRadius = "5px",
    i.style.padding = "5px",
    document.body.appendChild(i),
    o.focus(),
    o.select(),
    navigator.clipboard.writeText(o.value).then( () => {
        i.style.color = "#008800",
        i.style.display = "block",
        i.innerHTML = "<img src='data:image/png;base64, iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAR1JREFUeNpiYKAQMBJSsHDhQgEg1Q/ECVChD0DcGB8fP4GgAVDN+4HYAIt0IcgQJgIOQNZ8AYgnQF0AAvUgAqcBap7zFFpX/C3cdvpfIFSjI9DGQiC9AKoE5DoGFiwaQRLzgTgAxD9/9z8Q/z2A5CUHZPUsWDRj87OAnQ4TSG49ktwCFC9g0QzysyNIIVBzoK0O43o0uUJ4LODSXB3BXACkD0CjEUUOGB4fkA2YjxTPMM3Icc+ATTOyF9A1g9gKaJoPoGvGFgsbb21P+tDKAPbSBS9TpomGyowgDQ+AGh/gTMpAL7yHxitI8UQg9kfy8wagoYG40gvMCxOREkc9WoAl4kuqYM++vbPxgLCqPyNUIwdSPEeCvMRASwAQYADVrGCJVSOIewAAAABJRU5ErkJggg=='/> COPIED " + t + " EMAIL IDs TO CLIPBOARD"
    }
    ).catch(e => {
        i.style.color = "#ff0000",
        i.style.display = "block",
        i.innerHTML = "<img src='data:image/png;base64, iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAR1JREFUeNpiYKAQMBJSsHDhQgEg1Q/ECVChD0DcGB8fP4GgAVDN+4HYAIt0IcgQJgIOQNZ8AYgnQF0AAvUgAqcBap7zFFpX/C3cdvpfIFSjI9DGQiC9AKoE5DoGFiwaQRLzgTgAxD9/9z8Q/z2A5CUHZPUsWDRj87OAnQ4TSG49ktwCFC9g0QzysyNIIVBzoK0O43o0uUJ4LODSXB3BXACkD0CjEUUOGB4fkA2YjxTPMM3Icc+ATTOyF9A1g9gKaJoPoGvGFgsbb21P+tDKAPbSBS9TpomGyowgDQ+AGh/gTMpAL7yHxitI8UQg9kfy8wagoYG40gvMCxOREkc9WoAl4kuqYM++vbPxgLCqPyNUIwdSPEeCvMRASwAQYADVrGCJVSOIewAAAABJRU5ErkJggg=='/> NOT COPIED TO CLIPBOARD!<br/> Please try again!"
    }
    ),
    setTimeout(function() {
        o.remove(),
        i.remove()
    }, 2e3);
    $("#showCurrentUrl").html()
}
document.addEventListener("MutationObserver", function() {
    timeout && clearTimeout(timeout),
    1 == activeTab() && (timeout = setTimeout(reloader, 500))


    observer.observe(document, {
        childList: true,
        subtree: true
    });
}, !1),
chrome.runtime.sendMessage({
    options: "extensionenable"
}, function(e) {
    isextensionenabled = e.status,
    reloader()
}),
chrome.runtime.onMessage.addListener(function(e, t, n) {
    return "copyText" === e.message && copyToTheClipboard(e.textToCopy, e.elements),
    n(!0),
    !0


    
});
