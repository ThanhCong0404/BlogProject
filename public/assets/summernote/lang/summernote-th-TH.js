<script type="module">
(() => {
  // Extend the Summernote language object with Thai language
  $.extend($.summernote.lang, {
    'th-TH': {
      // Font options
      font: {
        bold: 'ตัวหนา',
        italic: 'ตัวเอียง',
        underline: 'ขีดเส้นใต้',
        clear: 'ล้างรูปแบบตัวอักษร',
        height: 'ความสูงบรรทัด',
        name: 'แบบตัวอักษร',
        strikethrough: 'ขีดฆ่า',
        subscript: 'ตัวห้อย',
        superscript: 'ตัวยก',
        size: 'ขนาดตัวอักษร'
      },
      // Image options
      image: {
        image: 'รูปภาพ',
        insert: 'แทรกรูปภาพ',
        resizeFull: 'ปรับขนาดเท่าจริง',
        resizeHalf: 'ปรับขนาดลง 50%',
        resizeQuarter: 'ปรับขนาดลง 25%',
        floatLeft: 'ชิดซ้าย',
        floatRight: 'ชิดขวา',
        floatNone: 'ไม่จัดตำแหน่ง',
        shapeRounded: 'Shape: Rounded',
        shapeCircle: 'Shape: Circle',
        shapeThumbnail: 'Shape: Thumbnail',
        shapeNone: 'Shape: None',
        dragImageHere: 'ลากรูปภาพที่ต้องการไว้ที่นี่',
        dropImage: 'วางรูปภาพหรือข้อความ',
        selectFromFiles: 'เลือกไฟล์รูปภาพ',
        maximumFileSize: 'ขนาดไฟล์ใหญ่สุด',
        maximumFileSizeError: 'ไฟล์เกินขนาดที่กำหนด',
        url
