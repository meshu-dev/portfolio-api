const MIME_TYPES = {
	'image/jpeg': 'jpg',
	'image/jpg': 'jpg',
	'image/gif': 'gif',
	'image/png': 'png'
};

class ImageHelper
{
	getExtFromMimeType(mimeType) {
		if (!mimeType) {
			mimeType = 'image/jpeg';
		}
		return MIME_TYPES[mimeType];
	}
}

module.exports = ImageHelper
