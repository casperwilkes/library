/**
 * Loops through a method and gets method parameters
 * @param  {Method} func The method to get parameters for
 * @return {Void}
 */
function getParamNames(func) {
    // Comment out below if giving problems//
    // Useful for stibo methods //
    var func = String(func);

    var STRIP_COMMENTS = /((\/\/.*$)|(\/\*[\s\S]*?\*\/))/mg;
    var ARGUMENT_NAMES = /([^\s,]+)/g;
    var fnStr = func.toString().replace(STRIP_COMMENTS, '');
    var result = fnStr.slice(fnStr.indexOf('(') + 1, fnStr.indexOf(')')).match(ARGUMENT_NAMES);

    if (result === null) {
        result = [];
    }

    return 'params: ' + result.join(', ');
}