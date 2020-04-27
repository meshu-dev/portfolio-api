class ProfileController
{
    constructor(profileModel) {
        this.profileModel = profileModel
    }
    async create(req, res) {
        let data = {
            name:        req.body.name,
            jobTitle:    req.body.jobTitle,
            bio:         req.body.bio,
            githubUrl:   req.body.githubUrl,
            linkedInUrl: req.body.linkedInUrl
        }
        let profile = await this.profileModel(data).save()
        res.json(profile)
    }
    async read(req, res) {
        let profile = await this.profileModel.find({ _id: req.params.id })
        res.json(profile[0] ? profile[0] : {})
    }
    async readRows(req, res) {
        let params  = req.query,
            filters = {},
            options = {
                skip:  params.skip ? parseInt(params.skip) : 0,
                limit: params.limit ? parseInt(params.limit) : 10
            }

        if (params.name) {
            filters.name = params.name
        }
        
        if (params.sort) {
            let sortFlag = params.sort === 'asc' ? 1 : -1
            options.sort = { createdAt: sortFlag }
        }
        
        let profiles = await this.profileModel.find(filters, null, options),
            total = await this.profileModel.countDocuments({})

        res.setHeader('X-Total-Count', total)
        res.json(profiles)
    }
    async update(req, res) {
        let data = {
            name:        req.body.name,
            jobTitle:    req.body.jobTitle,
            bio:         req.body.bio,
            githubUrl:   req.body.githubUrl,
            linkedInUrl: req.body.linkedInUrl
        }
        let profile = await this.profileModel.findOneAndUpdate({ _id: req.params.id }, { $set: data }, { new: true })
        res.json(profile)
    }
    async delete(req, res) {
        let isDeleted = await this.profileModel.findOneAndDelete({ _id: req.params.id })
        res.json({})
    }
}

module.exports = ProfileController
