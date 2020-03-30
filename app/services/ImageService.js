class ImageService
{
	constructor(fileSystem, fileService) {
		this.fileSystem = fileSystem;
		this.fileService = fileService;
	}
	upload(filePath, filename, callback) {
		let fileStream = this.fileSystem.createReadStream(filePath);

		fileStream.on('error', function(err) {
			console.log('File Error', err);
		});

		this.fileService.upload(filename, fileStream, callback);
	}
	delete(key, callback) {
		this.fileService.delete(key, callback);
	}
}

module.exports = ImageService
