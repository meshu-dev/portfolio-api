class ImageController
{
	constructor(imageService, imageModel) {
		this.imageService = imageService
		this.imageModel = imageModel
	}
	async create(req, res) {
		let result = await new Promise((resolve, reject) => {
	        this.imageService.upload(
	        	req.file.path,
	        	req.file.originalname,
				function (err, data) {
					if (err) {
						console.log("Error", err);
					} if (data) {
						console.log("Upload Success", data.Location);
					}
					resolve(data);
				}
	        )
		});
		let data = {
			filename: result.Key,
	        url:      result.Location
		}
        let image = await this.imageModel(data).save()
        res.json(image)

	}
	async read(req, res) {
		let image = await this.imageModel.find({ _id: req.params.id })
        res.json(image[0] ? image[0] : {})
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
		
		let images = await this.imageModel.find({}, null, options),
			total = await this.imageModel.countDocuments({})

		res.setHeader('X-Total-Count', total)
        res.json(images)
	}
	/*
	async update(req, res) {
		let data = {
	        filename: req.body.filename,
	        url:      req.body.url
		}
		let image = await this.imageModel.findOneAndUpdate({ _id: req.params.id }, { $set: data }, { new: true })
        res.json(image)
	} */
	async delete(req, res) {
		let image = await this.imageModel.find({ _id: req.params.id })
		image = image[0] ? image[0] : {}

		let result = await new Promise((resolve, reject) => {
	        this.imageService.delete(
	        	image.filename,
				function (err, data) {
				   	if (err)
				   		console.log(err, err.stack); // an error occurred
				   	else
				   		console.log(data);           // successful response

				   	resolve(data);
				}
	        )
		});

		let isDeleted = await this.imageModel.findOneAndDelete({ _id: req.params.id })
        res.json({})
	}
}

module.exports = ImageController
