let express        = require('express'),
	router         = express.Router(),
	BlogController = require('./../controllers/BlogController'),
	blogController = new BlogController(require('./../models/BlogModel'))

router.post('/',      blogController.create.bind(blogController))
router.get('/:id',    blogController.read.bind(blogController))
router.get('/',       blogController.readRows.bind(blogController))
router.put('/:id',    blogController.update.bind(blogController))
router.delete('/:id', blogController.delete.bind(blogController))

module.exports = router
