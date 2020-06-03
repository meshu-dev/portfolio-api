let express = require('express'),
  router = express.Router(),
  ProfileController = require('./../controllers/ProfileController'),
  profileController = new ProfileController(
    require('./../models/ProfileModel')
  );

router.post('/', profileController.create.bind(profileController));
router.get('/:id', profileController.read.bind(profileController));
router.get('/', profileController.readRows.bind(profileController));
router.put('/:id', profileController.update.bind(profileController));
router.delete('/:id', profileController.delete.bind(profileController));

module.exports = router;
