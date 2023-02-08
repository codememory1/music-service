import DragAndDropErrorService from '~/services/ui/drag-and-drop/drag-and-drop-error-service';
import sizeConverter from '~/utils/size-converter';
import DragAndDropService from '~/services/ui/drag-and-drop/drag-and-drop-service';

export default class DragAndDropValidationService {
  public readonly dragAndDropService: DragAndDropService;
  private errors: Array<DragAndDropErrorService> = [];

  public constructor(dragAndDropService: DragAndDropService) {
    this.dragAndDropService = dragAndDropService;
  }

  public addValidateNumberUploadedFiles(max: number): void {
    if (this.dragAndDropService.isMaxUploadedFiles(max)) {
      this.errors.push(
        new DragAndDropErrorService(
          'alert.titles.upload_files',
          'alert.messages.unable_add_file_max_number',
          {
            max_files: max
          }
        )
      );
    }
  }

  public addValidateMinSize(min: number, file: File): void {
    if (this.dragAndDropService.fileSizeIsLessMin(min, file)) {
      const size = sizeConverter(min);

      this.errors.push(
        new DragAndDropErrorService(
          'alert.titles.upload_files',
          'alert.messages.unable_add_file_min_size',
          {
            size: size.size,
            unit: size.name
          }
        )
      );
    }
  }

  public addValidateMaxSize(max: number, file: File): void {
    if (this.dragAndDropService.fileSizeIsLargerMax(max, file)) {
      const size = sizeConverter(max);

      this.errors.push(
        new DragAndDropErrorService(
          'alert.titles.upload_files',
          'alert.messages.unable_add_file_max_size',
          {
            size: size.size,
            unit: size.name
          }
        )
      );
    }
  }

  public addValidateMimeTypes(allowedMimeTypes: Array<string>, file: File): void {
    if (this.dragAndDropService.fileDoesNotContainAllowedMimeTypes(allowedMimeTypes, file)) {
      this.errors.push(
        new DragAndDropErrorService(
          'alert.titles.upload_files',
          'alert.messages.unable_add_file_not_allowed_mime_type',
          { mime_types: allowedMimeTypes.join(', ') }
        )
      );
    }
  }

  public validate(errorCallback: (error: DragAndDropErrorService) => void): void {
    if (this.errors.length > 0) {
      errorCallback(this.errors[0]);
    }
  }

  public isValidated(): boolean {
    return this.errors.length === 0;
  }
}
