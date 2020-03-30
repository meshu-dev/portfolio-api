let express         = require('express'),
	router          = express.Router(),
	ImageController = require('./../controllers/ImageController'),
	aws             = require('aws-sdk'),
	S3Service       = require('./../services/S3Service'),
	s3Service       = new S3Service(
		aws,
		new aws.S3(),
		process.env.AWS_S3_BUCKET
	),
	ImageService    = require('./../services/ImageService'),
	imageService    = new ImageService(require('fs'), s3Service),
	imageController = new ImageController(
		imageService,
		require('./../models/ImageModel')
	)

var multer = require('multer')
var upload = multer({ dest: 'uploads/' })

router.post('/',      upload.single('image'), imageController.create.bind(imageController))
router.get('/:id',    imageController.read.bind(imageController))
router.get('/',       imageController.readRows.bind(imageController))
//router.put('/:id',    imageController.update.bind(imageController))
router.delete('/:id', imageController.delete.bind(imageController))

module.exports = router
