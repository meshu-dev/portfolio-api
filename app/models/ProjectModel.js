const mongoose = require('mongoose')

let projectSchema = new mongoose.Schema({
        title: {
            type: String,
            unique: false,
            required: true
        },
        description: {
            type: String,
            unique: false,
            required: true
        },
        url: {
            type: String,
            unique: false,
            required: true
        },
        thumbUrl: {
            type: String,
            unique: false,
            required: true
        }
    }, {
        timestamps: true
    }
)

projectSchema.set('toJSON', {
    versionKey: false
})

projectSchema.options.toJSON.transform = (doc, ret, options) => {
    let idObj = { id: ret._id }
    delete ret._id

    return Object.assign({}, idObj, ret)
}


module.exports = mongoose.model('Project', projectSchema)
