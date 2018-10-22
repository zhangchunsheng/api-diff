var compare = (function(document, window) {
    "use strict";
    var _handleFormSubmit = function(e) {
            var resp1, resp2 = $("#RESULTS_1").val(),
                resultsDiff = $("#RESULTS_DIFF"),
                delta;

            resp1 = $("#RESULTS_1").val();
            resp2 = $("#RESULTS_2").val();

            if(typeof(resp1) == "string") {
                resp1 = JSON.parse(resp1);
            }
            if(typeof(resp2) == "string") {
                resp2 = JSON.parse(resp2);
            }

            //if (resp1Str === resp2Str) {
            if (_deepCompare(resp1, resp2)) {
                resultsDiff.html("NO DIFF SINCE THEY ARE EQUAL");
            } else {
                // Show the delta
                delta = jsondiffpatch.diff(resp1, resp2);
                resultsDiff.html("");
                resultsDiff.html(jsondiffpatch.formatters.html.format(delta, resp1));
                jsondiffpatch.formatters.html.hideUnchanged();
            }
        },

        _deepCompare = function() {
            var i,
                l,
                leftChain,
                rightChain;

            function _compare2Objects(x, y) {
                var p;

                // remember that NaN === NaN returns false
                // and isNaN(undefined) returns true
                if (isNaN(x) && isNaN(y) && typeof x === 'number' && typeof y === 'number') {
                    return true;
                }

                // Compare primitives and functions.
                // Check if both arguments link to the same object.
                // Especially useful on step when comparing prototypes
                if (x === y) {
                    return true;
                }

                // Works in case when functions are created in constructor.
                // Comparing dates is a common scenario. Another built-ins?
                // We can even handle functions passed across iframes
                if ((typeof x === 'function' && typeof y === 'function') ||
                    (x instanceof Date && y instanceof Date) ||
                    (x instanceof RegExp && y instanceof RegExp) ||
                    (x instanceof String && y instanceof String) ||
                    (x instanceof Number && y instanceof Number)) {
                    return x.toString() === y.toString();
                }

                // At last checking prototypes as good a we can
                if (!(x instanceof Object && y instanceof Object)) {
                    return false;
                }

                if (x.isPrototypeOf(y) || y.isPrototypeOf(x)) {
                    return false;
                }

                if (x.constructor !== y.constructor) {
                    return false;
                }

                if (x.prototype !== y.prototype) {
                    return false;
                }

                // Check for infinitive linking loops
                if (leftChain.indexOf(x) > -1 || rightChain.indexOf(y) > -1) {
                    return false;
                }

                // Quick checking of one object beeing a subset of another.
                // todo: cache the structure of arguments[0] for performance
                for (p in y) {
                    if (y.hasOwnProperty(p) !== x.hasOwnProperty(p)) {
                        return false;
                    } else if (typeof y[p] !== typeof x[p]) {
                        return false;
                    }
                }

                for (p in x) {
                    if (y.hasOwnProperty(p) !== x.hasOwnProperty(p)) {
                        return false;
                    } else if (typeof y[p] !== typeof x[p]) {
                        return false;
                    }

                    switch (typeof(x[p])) {
                        case 'object':
                        case 'function':
                            leftChain.push(x);
                            rightChain.push(y);

                            if (!_compare2Objects(x[p], y[p])) {
                                return false;
                            }

                            leftChain.pop();
                            rightChain.pop();
                            break;

                        default:
                            if (x[p] !== y[p]) {
                                return false;
                            }
                            break;
                    }
                }
                return true;
            }
            if (arguments.length < 1) {
                return true; //Die silently? Don't know how to handle such case, please help...
                // throw "Need two or more arguments to compare";
            }

            for (i = 1, l = arguments.length; i < l; i++) {
                leftChain = []; //Todo: this can be cached
                rightChain = [];

                if (!_compare2Objects(arguments[0], arguments[i])) {
                    return false;
                }
            }
            return true;
        };

    return {
        init: function() {
            // Add event handler
            $("#compare").on("click", _handleFormSubmit);
        }
    };
}(document, window));

$(function() {
    "use strict";
    compare.init();
});