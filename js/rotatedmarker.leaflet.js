/**
 * Rotated Marker.
 *
 * The Rotated Marker library makes it possible to rotate the markers and with that have the flight going towards the exact heading instead of making 360 images.
 *
 * @author Benjamin Becquet
 * @copyright Benjamin Becquet
 * @license MIT
 */

L.RotatedMarker = L.Marker.extend({
    options: {
        angle: 0
    },

    _setPos: function (pos) {
        L.Marker.prototype._setPos.call(this, pos);

        if (L.DomUtil.TRANSFORM) {
            this._icon.style[L.DomUtil.TRANSFORM] += ' rotate(' + this.options.angle + 'deg)';
        } else if(L.Browser.ie) {
            var rad = this.options.angle * (Math.PI / 180),
                costheta = Math.cos(rad),
                sintheta = Math.sin(rad);
            this._icon.style.filter += ' progid:DXImageTransform.Microsoft.Matrix(sizingMethod=\'auto expand\', M11=' +
                costheta + ', M12=' + (-sintheta) + ', M21=' + sintheta + ', M22=' + costheta + ')';
        }
    }
});

L.rotatedMarker = function (pos, options) {
    return new L.RotatedMarker(pos, options);
};