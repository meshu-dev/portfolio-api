class ImageStorageService {
  constructor(fileSystem, storageService) {
    this.fileSystem = fileSystem;
    this.storageService = storageService;
  }
  upload(filePath, filename, callback) {
    let fileStream = this.fileSystem.createReadStream(filePath);

    fileStream.on('error', function (err) {
      console.log('File Error', err);
    });

    this.storageService.upload(filename, fileStream, callback);
  }
  delete(key, callback) {
    this.storageService.delete(key, callback);
  }
}

module.exports = ImageStorageService;
