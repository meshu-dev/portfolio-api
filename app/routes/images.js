let express = require('express'),
  router = express.Router(),
  ImageController = require('./../controllers/ImageController'),
  aws = require('aws-sdk'),
  awsS3 = new aws.S3(),
  S3Service = require('./../services/S3Service'),
  ImageStorageService = require('./../services/ImageStorageService'),
  ImageEditorService = require('./../services/ImageEditorService'),
  ImageHelper = require('./../helpers/ImageHelper'),
  imageHelper = new ImageHelper(),
  imageModel = require('./../models/ImageModel'),
  fileSystem = require('fs'),
  multer = require('multer'),
  sharp = require('sharp');

let s3Service = new S3Service(aws, awsS3, process.env.AWS_S3_BUCKET);

let imageStorageService = new ImageStorageService(fileSystem, s3Service);

let imageEditorService = new ImageEditorService(sharp);

let imageController = new ImageController(
  imageStorageService,
  imageEditorService,
  imageHelper,
  imageModel
);

let upload = multer({dest: 'uploads/'});

router.post(
  '/',
  upload.single('image'),
  imageController.create.bind(imageController)
);
router.get('/:id', imageController.read.bind(imageController));
router.get('/', imageController.readRows.bind(imageController));
router.delete('/', imageController.delete.bind(imageController));

module.exports = router;
