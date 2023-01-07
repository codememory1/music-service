import { Vue } from 'vue-property-decorator';

export default class DragAndDropService {
  public readonly app: Vue;
  private uploadedFiles: Array<File> = [];

  public constructor(app: Vue) {
    this.app = app;
  }

  public addFile(file: File): DragAndDropService {
    this.uploadedFiles.push(file);

    this.app.$emit('uploadFile', file);

    return this;
  }

  public removeFile(index: number): DragAndDropService {
    this.uploadedFiles.remove(index);

    return this;
  }

  public getUploadedFiles(): Array<File> {
    return this.uploadedFiles;
  }

  public isMaxUploadedFiles(max: number): boolean {
    return max !== -1 && this.getUploadedFiles().length >= max;
  }

  public fileSizeIsLessMin(min: number, file: File): boolean {
    return min !== -1 && file.size < min;
  }

  public fileSizeIsLargerMax(max: number, file: File): boolean {
    return max !== -1 && file.size > max;
  }

  public fileDoesNotContainAllowedMimeTypes(types: Array<string>, file: File): boolean {
    return types.length !== 0 && !types.includes(file.type);
  }
}
