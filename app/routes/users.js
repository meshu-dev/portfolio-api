let express = require('express'),
  router = express.Router(),
  UserController = require('./../controllers/UserController'),
  userController = new UserController(require('./../models/UserModel'));

router.post('/', userController.create.bind(userController));
router.get('/:id', userController.read.bind(userController));
router.get('/', userController.readRows.bind(userController));
router.put('/:id', userController.update.bind(userController));
router.delete('/:id', userController.delete.bind(userController));

router.post('/login', userController.login.bind(userController));

module.exports = router;
