class ImageController {
  static imgWidth = 650;
  static imgHeight = 487;
  static imgThumbWidth = 318;
  static imgThumbHeight = 200;

  constructor(
    imageStorageService,
    imageEditorService,
    imageHelper,
    imageModel
  ) {
    this.imageStorageService = imageStorageService;
    this.imageEditorService = imageEditorService;
    this.imageHelper = imageHelper;
    this.imageModel = imageModel;
  }
  async create(req, res) {
    let fileExt = this.imageHelper.getExtFromMimeType(req.file.mimetype);

    let uploadData = await this.uploadImage(
      req.file.path,
      `${Date.now()}.${fileExt}`,
      ImageController.imgWidth,
      ImageController.imgHeight
    );

    let uploadThumbData = await this.uploadImage(
      req.file.path,
      `${Date.now()}.${fileExt}`,
      ImageController.imgThumbWidth,
      ImageController.imgThumbHeight
    );

    let data = {
      imageKey: uploadData.Key,
      thumbKey: uploadThumbData.Key,
      imageUrl: uploadData.Location,
      thumbUrl: uploadThumbData.Location,
    };
    let image = await this.imageModel(data).save();
    res.json(image);
  }
  async uploadImage(filePath, filename, width, height) {
    let newFilePath = `uploads/${filename}`;

    await this.imageEditorService.resize(filePath, newFilePath, width, height);

    return await new Promise((resolve) => {
      this.imageStorageService.upload(newFilePath, filename, function (
        err,
        data
      ) {
        if (err) {
          console.log('Error', err);
        }
        if (data) {
          console.log('Upload Success', data.Location);
        }
        resolve(data);
      });
    });
  }
  async read(req, res) {
    let image = await this.imageModel.find({_id: req.params.id});
    res.json(image[0] ? image[0] : {});
  }
  async readRows(req, res) {
    let params = req.query,
      options = {
        skip: params.skip ? parseInt(params.skip) : 0,
        limit: params.limit ? parseInt(params.limit) : 10,
      };

    if (params.sort) {
      let sortFlag = params.sort === 'asc' ? 1 : -1;
      options.sort = {createdAt: sortFlag};
    }

    let images = await this.imageModel.find({}, null, options),
      total = await this.imageModel.countDocuments({});

    res.setHeader('X-Total-Count', total);
    res.json(images);
  }
  async delete(req, res) {
    //let image = await this.imageModel.find({ _id: req.params.id })
    //image = image[0] ? image[0] : {}

    let imageKey = req.body.imageKey;
    let thumbKey = req.body.thumbKey;

    console.log('imageKey', imageKey);
    console.log('thumbKey', thumbKey);

    let imageResult = await this.deleteImage(imageKey);
    let thumbResult = await this.deleteImage(thumbKey);

    console.log('imageResult', imageResult);
    console.log('thumbResult', thumbResult);

    //let isDeleted = await this.imageModel.findOneAndDelete({ _id: req.params.id })
    res.json({});
  }
  async deleteImage(key) {
    return await new Promise((resolve) => {
      this.imageStorageService.delete(key, function (err, data) {
        if (err) console.log(err, err.stack);
        // an error occurred
        else console.log(data); // successful response

        resolve(data);
      });
    });
  }
}

module.exports = ImageController;
