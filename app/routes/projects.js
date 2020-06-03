let express = require('express'),
  router = express.Router(),
  ProjectController = require('./../controllers/ProjectController'),
  projectController = new ProjectController(
    require('./../models/ProjectModel')
  );

router.post('/', projectController.create.bind(projectController));
router.get('/:id', projectController.read.bind(projectController));
router.get('/', projectController.readRows.bind(projectController));
router.put('/:id', projectController.update.bind(projectController));
router.delete('/:id', projectController.delete.bind(projectController));

module.exports = router;
