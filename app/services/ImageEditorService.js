class ImageEditorService
{
	constructor(
		fileEditor
	) {
		this.fileEditor = fileEditor;
	}
	async resize(filePath, newFilePath, width, height, callback) {
		let options = {
			fit: 'fill'
		};

		await this.fileEditor(filePath)
			.resize(width, height, options)
			.toFile(newFilePath);
	}
}

module.exports = ImageEditorService
