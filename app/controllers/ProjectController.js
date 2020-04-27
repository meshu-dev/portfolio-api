class ProjectController
{
    constructor(projectModel) {
        this.projectModel = projectModel
    }
    async create(req, res) {
        let data = {
            title:        req.body.title,
            description:  req.body.description,
            technologies: req.body.technologies,
            repositories: req.body.repositories,
            images:       req.body.images
        }
        let project = await this.projectModel(data).save()
        res.json(project)
    }
    async read(req, res) {
        let project = await this.projectModel.find({ _id: req.params.id })
        res.json(project[0] ? project[0] : {})
    }
    async readRows(req, res) {
        let params = req.query,
            options = {
                skip:  params.skip ? parseInt(params.skip) : 0,
                limit: params.limit ? parseInt(params.limit) : 10
            }

        if (params.sort) {
            let sortFlag = params.sort === 'asc' ? 1 : -1
            options.sort = { createdAt: sortFlag }
        }

        let projects = await this.projectModel.find({}, null, options),
            total = await this.projectModel.countDocuments({})

        res.setHeader('X-Total-Count', total)
        res.json(projects)
    }
    async update(req, res) {
        let data = {
            title:        req.body.title,
            description:  req.body.description,
            technologies: req.body.technologies,
            repositories: req.body.repositories,
            images:       req.body.images
        }
        let project = await this.projectModel.findOneAndUpdate({ _id: req.params.id }, { $set: data }, { new: true })
        res.json(project)
    }
    async delete(req, res) {
        let isDeleted = await this.projectModel.findOneAndDelete({ _id: req.params.id })
        res.json({})
    }
}

module.exports = ProjectController
